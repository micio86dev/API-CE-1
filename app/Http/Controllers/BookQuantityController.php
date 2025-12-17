<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Controllers\BaseController;

use App\Http\Requests\IndexQuantityBookRequest;
use App\Http\Requests\StoreBookQuantityRequest;
use App\Http\Requests\UpdateBookQuantityRequest;
use App\Http\Resources\BookQuantityResource;
use App\Http\Resources\BookQuantityDetailResource;

use Illuminate\Http\JsonResponse;

class BookQuantityController extends BaseController
{
    protected string $primaryModel = BookQuantity::class;
    protected ?string $primaryResource = BookQuantityResource::class;
    protected ?string $primaryDetailResource = BookQuantityDetailResource::class;
    protected array $fillableFields = ['book_id', 'quantity', 'location_id'];
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
    public function index(IndexBookQuantityRequest $request): JsonResponse
    {
        return parent::baseIndex($request);
    }

    /**
     * Store a new book.
     */
    public function store(StoreBookQuantityRequest $request): JsonResponse
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
    public function update(UpdateBookQuantityRequest $request, int $id): JsonResponse
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

    /**
     * Remove the specified book.
     */
    public function moveBooks(MoveBooksRequest $request): JsonResponse
    {
        // Logic to move books between locations
        return $this->jsonData();
    }

    /**
     * Remove the specified book.
     */
    public function cancelMoveBooks(CancelMoveBooksRequest $request): JsonResponse
    {
        // Logic to cancel moving books between locations
        return $this->jsonData();
    }
}
