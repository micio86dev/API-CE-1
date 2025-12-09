<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Http\Resources\LocationResource;
use App\Http\Resources\LocationDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\IndexLocationRequest;

class LocationController extends BaseController
{   
    protected string $primaryModel = Location::class;
    protected ?string $primaryResource = LocationResource::class;
    protected ?string $primaryDetailResource = LocationDetailResource::class;
    protected array $fillableFields = ['name', 'phone_number', 'email', 'customer_id'];
    protected array $indexRelations = ['customer', 'address', 'types'];
    protected array $detailRelations = ['customer', 'address', 'types', 'books'];
    protected array $belongsToManyRelations = ['books'];
    protected array $hasManyRelations = [];
    protected array $hasOneRelations = [];
    protected array $morphOneRelations = ['address'];
    protected array $searchableFields = [
        'like' => [
            'name',
            'email',
        ],
        'equal' => [
            'phone_number',
            'customer_id',
        ],
    ];

    protected array $relationFilters = [
        'like' => [
            'customer' => ['name'],
            'address' => ['city'],
        ],
        'equal' => [
            'address' => ['province', 'country', 'street', 'street_number', 'zip'],
            'customer' => ['mine'],
        ],
    ];

    protected array $globalSearch = [
        'columns' => ['name', 'phone_number', 'email'],
        'relations' => [
            'customer' => ['name'],
            'address' => ['city', 'province', 'country', 'street', 'street_number', 'zip'],
        ],
    ];

    protected function select(): array
    {
        return ['id', 'name', 'phone_number', 'email', 'customer_id', 'created_at', 'updated_at'];
    }
    
    /**
     * Display all locations.
     */
    public function index(IndexLocationRequest $request): JsonResponse
    {
        return parent::baseIndex($request);
    }

    /**
     * Store a new location.
     */
    public function store(StoreLocationRequest $request): JsonResponse
    {
        return parent::baseStore($request);
    }

    /**
     * Display the specified location.
     */
    public function show(int $id): JsonResponse
    {
        return parent::baseShow($id);
    }

    /**
     * Update the specified location.
     */
    public function update(UpdateLocationRequest $request, int $id): JsonResponse
    {
        return parent::baseUpdate($request, $id);
    }

    /**
     * Remove the specified location.
     */
    public function destroy(int $id): JsonResponse
    {
        return parent::baseDestroy($id);
    }
}
