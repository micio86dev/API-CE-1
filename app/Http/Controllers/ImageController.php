<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Customer;
use App\Models\Image;
use App\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    /**
     * Generic upload endpoint (no parent model yet).
     */
    public function store(StoreImageRequest $request): JsonResponse
    {
        $dateFolder = now()->format('Y/m/d');
        return $this->storeFor($request, null, "images/uploads/{$dateFolder}");
    }

    public function storeForBook(StoreImageRequest $request, int $id): JsonResponse
    {
        $book = Book::findOrFail($id);
        return $this->storeOrAttach($request, $book, "images/books/{$book->id}");
    }

    public function storeForAuthor(StoreImageRequest $request, int $id): JsonResponse
    {
        $author = Author::findOrFail($id);
        return $this->storeOrAttach($request, $author, "images/authors/{$author->id}");
    }

    public function storeForLocation(StoreImageRequest $request, int $id): JsonResponse
    {
        $location = Location::findOrFail($id);
        return $this->storeOrAttach($request, $location, "images/locations/{$location->id}");
    }

    public function storeForCustomer(StoreImageRequest $request, int $id): JsonResponse
    {
        $customer = Customer::findOrFail($id);
        return $this->storeOrAttach($request, $customer, "images/customers/{$customer->id}");
    }

    private function storeOrAttach(StoreImageRequest $request, Model $parent, string $folder): JsonResponse
    {
        if ($request->hasFile('image')) {
            return $this->storeFor($request, $parent, $folder);
        }

        // Otherwise, validated request guarantees image_id is present.
        return $this->attachExisting($request, $parent);
    }

    private function attachExisting(StoreImageRequest $request, Model $parent): JsonResponse
    {
        $validated = $request->validated();

        /** @var Image $image */
        $image = Image::query()->findOrFail($validated['image_id']);

        // Prevent accidentally re-attaching an image to a different parent.
        if (!empty($image->model_type) && !empty($image->model_id)) {
            $sameParent = $image->model_type === $parent::class && (int) $image->model_id === (int) $parent->getKey();
            if (!$sameParent) {
                return response()->json([
                    'message' => 'Image is already attached to a different resource.', //TODO: translate
                ], 409);
            }
        }

        $updated = DB::transaction(function () use ($validated, $parent, $image) {
            if (!empty($validated['is_primary'])) {
                Image::where('model_type', $parent::class)
                    ->where('model_id', $parent->getKey())
                    ->update(['is_primary' => false]);
                $image->is_primary = true;
            }

            if (isset($validated['sort_order'])) {
                $image->sort_order = $validated['sort_order'];
            }

            if (isset($validated['meta'])) {
                $image->meta = $validated['meta'];
            }

            // sets model_id + model_type
            $image->model()->associate($parent);
            $image->save();

            if (isset($validated['types'])) {
                $image->types()->sync($validated['types'] ?? []);
            }

            return $image->fresh(['types']);
        });

        return response()->json(['data' => $updated], 200);
    }

    private function storeFor(StoreImageRequest $request, ?Model $parent, string $folder): JsonResponse
    {
        $validated = $request->validated();
        $file = $request->file('image');

        $disk = 'local'; 
        $filename = (string) Str::uuid() . '.' . $file->extension();

        // Store file first; if DB fails, we'll delete it in catch.
        $path = Storage::disk($disk)->putFileAs($folder, $file, $filename);

        try {
            /** @var Image $image */
            $image = DB::transaction(function () use ($validated, $parent, $disk, $path, $file) {
                // If this upload is primary, unset other primaries for same parent
                if ($parent && !empty($validated['is_primary'])) {
                    Image::where('model_type', $parent::class)
                        ->where('model_id', $parent->getKey())
                        ->update(['is_primary' => false]);
                }

                $image = new Image([
                    'disk' => $disk,
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                    'meta' => $validated['meta'] ?? null,
                    'sort_order' => $validated['sort_order'] ?? 0,
                    'is_primary' => (bool) ($parent ? ($validated['is_primary'] ?? false) : false),
                ]);

                if ($parent) {
                    // sets model_id + model_type
                    $image->model()->associate($parent);
                }
                $image->save();

                // Attach categories (cover/avatar/gallery) via has_types
                if (isset($validated['types'])) {
                    $image->types()->sync($validated['types'] ?? []);
                }

                return $image->fresh(['types']);
            });

            return response()->json(['data' => $image], 201);
        } catch (\Throwable $e) {
            Storage::disk($disk)->delete($path);
            throw $e;
        }
    }
}