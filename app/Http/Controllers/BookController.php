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
use Illuminate\Foundation\Http\FormRequest;


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

    protected function applyRelationFilters(FormRequest $request, $query)
    {
        // Author first name
        if ($first_name = $request->input('authors.first_name')) {
            $query->whereHas('authors', function ($q) use ($first_name) {
                $q->where('first_name', 'equal', $first_name);
            });
        }

        // Author last name
        if ($last_name = $request->input('authors.last_name')) {
            $query->whereHas('authors', function ($q) use ($last_name) {
                $q->where('last_name', 'equal', $last_name);
            });
        }

        // Type name
        if ($type_name = $request->input('types.name')) {
            $query->whereHas('types', function ($q) use ($type_name) {
                $q->where('name', 'equal', $type_name);
            });
        }

        // Collection name
        if ($collection_name = $request->input('collection.name')) {
            $query->whereHas('collection', function ($q) use ($collection_name) {
                $q->where('name', 'equal', $collection_name);
            });
        }
    }

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
}
