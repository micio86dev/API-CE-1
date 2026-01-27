<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\IndexCollectionRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\CollectionDetailResource;
use App\Http\Requests\StoreCollectionRequest;
use App\Http\Requests\UpdateCollectionRequest;

class CollectionController extends BaseController
{   
    protected string $primaryModel = Collection::class;
    protected ?string $primaryResource = CollectionResource::class;
    protected ?string $primaryDetailResource = CollectionDetailResource::class;
    protected array $fillableFields = ['name', 'description', 'published_at'];
    protected array $indexRelations = ['books'];
    protected array $detailRelations = ['books'];
    protected array $belongsToManyRelations = [];
    protected array $hasManyRelations = [];
    protected array $hasOneRelations = [];
    protected array $morphOneRelations = [];
    protected array $searchableFields = [
        'like' => [
            'name',
        ],
    ];

    protected array $relationFilters = [
        'like' => [
            'books' => ['title'],
        ],
    ];

    protected array $globalSearch = [
        'columns' => ['name', 'description'],
        'relations' => [
            'books' => ['title'],
        ],
    ];
    protected function select(): array
    {
        return ['id', 'name', 'description'];
    }

    /**
     * Display all collections.
     */
    public function index(IndexCollectionRequest $request): JsonResponse
    {
        return parent::baseIndex($request);
    }

    /**
     * Store a new collection.
     */
    public function store(StoreCollectionRequest $request): JsonResponse
    {
        return parent::baseStore($request);
    }

    /**
     * Display the specified collection.
     */
    public function show(int $id): JsonResponse
    {
        return parent::baseShow($id);
    }

    /**
     * Update the specified collection.
     */
    public function update(UpdateCollectionRequest $request, int $id): JsonResponse
    {
        return parent::baseUpdate($request, $id);
    }

    /**
     * Remove the specified collection.
     */
    public function destroy(int $id): JsonResponse
    {
        return parent::baseDestroy($id);
    }
}
