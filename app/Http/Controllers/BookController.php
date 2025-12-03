<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookDetailResource;
use Illuminate\Http\JsonResponse;


class BookController extends BaseController
{
    protected string $primaryModel = Book::class;
    protected ?string $primaryResource = BookResource::class;
    protected ?string $primaryDetailResource = BookDetailResource::class;
    protected array $fillableFields = ['title', 'price', 'plot', 'published_at', 'collection_id'];
    protected array $indexRelations = ['collection', 'authors', 'types'];
    protected array $detailRelations = ['collection', 'authors', 'types', 'locations'];
    protected array $belongsToManyRelations = ['authors', 'types'];
    protected array $hasManyRelations = ['quantities'];
    protected array $hasOneRelations = [];
    protected array $morphOneRelations = [];

    protected function select(): array
    {
        return ['id', 'title', 'price', 'plot', 'collection_id', 'published_at', 'created_at', 'updated_at'];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return parent::baseIndex();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        return parent::baseStore($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        return parent::baseShow($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, int $id): JsonResponse
    {
        return parent::baseUpdate($request, $id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        return parent::baseDestroy($id);
    }
}
