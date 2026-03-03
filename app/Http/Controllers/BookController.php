<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookDetailResource;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\IndexBookRequest;

class BookController extends BaseController
{
    protected string $primaryModel = Book::class;
    protected ?string $primaryResource = BookResource::class;
    protected ?string $primaryDetailResource = BookDetailResource::class;
    protected array $fillableFields = ['title', 'price', 'plot', 'published_at', 'collection_id'];
    protected array $indexRelations = ['collection', 'authors', 'types'];
    protected array $detailRelations = ['collection', 'authors', 'types', 'locations', 'quantities'];
    protected array $belongsToManyRelations = ['authors', 'types', 'locations'];
    protected array $hasManyRelations = ['quantities'];
    protected array $hasOneRelations = [];
    protected array $morphOneRelations = [];
    protected array $searchableFields = [
        'like' => [
            'title',
        ],
        'less_than' => [
            'max_price'        => 'price',
            'published_before' => 'published_at',
        ],
        'greater_than' => [
            'min_price'        => 'price',
            'published_after'  => 'published_at',
        ],
    ];

    protected array $relationFilters = [
        'equal' => [
            'collection' => ['name'],
            'authors' => ['first_name', 'last_name'],
            'types' => ['name'],
        ],
    ];

    protected array $globalSearch = [
        'columns' => ['title', 'price', 'plot'],
        'relations' => [
            'collection' => ['name'],
            'authors' => ['first_name', 'last_name'],
            'types' => ['name'],
        ],
    ];

    protected function select(): array
    {
        return ['id', 'title', 'price', 'plot', 'collection_id', 'published_at', 'created_at', 'updated_at'];
    }

    /**
     * Display all books.
     */
    public function index(IndexBookRequest $request): JsonResponse
    {
        return parent::baseIndex($request);
    }

    /**
     * Store a new book.
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        return parent::baseStore($request);
    }

    /**
     * Display the specified book.
     */
    public function show(int $id): JsonResponse
    {
        return parent::baseShow($id);
    }

    /**
     * Update the specified book.
     */
    public function update(UpdateBookRequest $request, int $id): JsonResponse
    {
        return parent::baseUpdate($request, $id);
    }

    /**
     * Remove the specified book.
     */
    public function destroy(int $id): JsonResponse
    {
        return parent::baseDestroy($id);
    }

    public function uploadFrontCover(\Illuminate\Http\Request $request, int $id): JsonResponse
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'front_cover' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $book
            ->addMedia($request->file('front_cover'))
            ->toMediaCollection('front_cover');

        return response()->json([
            'message' => 'Front cover uploaded successfully.',
            'front_cover_url' => $book->getFirstMediaUrl('front_cover'),
        ], 200);
    }

    public function uploadBackCover(\Illuminate\Http\Request $request, int $id): JsonResponse
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'back_cover' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $book
            ->addMedia($request->file('back_cover'))
            ->toMediaCollection('back_cover');

        return response()->json([
            'message' => 'Back cover uploaded successfully.',
            'back_cover_url' => $book->getFirstMediaUrl('back_cover'),
        ], 200);
    }
}
