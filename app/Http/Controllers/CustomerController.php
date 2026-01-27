<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\CustomerDetailResource;
use App\Http\Requests\IndexCustomerRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends BaseController
{   
    protected string $primaryModel = Customer::class;
    protected ?string $primaryResource = CustomerResource::class;
    protected ?string $primaryDetailResource = CustomerDetailResource::class;
    protected array $fillableFields = ['name', 'mine'];
    protected array $indexRelations = ['locations', 'locations.address'];
    protected array $detailRelations = ['locations', 'locations.address', 'locations.types'];
    protected array $belongsToManyRelations = [];
    protected array $hasManyRelations = ['locations'];
    protected array $hasOneRelations = [];
    protected array $morphOneRelations = [];
    protected array $searchableFields = [
        'like' => [
            'name',
        ],
        'equal' => [
            'mine',
        ],
    ];

    protected array $relationFilters = [
        'equal' => [
            'locations.address' => ['city', 'province', 'country', 'street', 'street_number', 'zip'],
        ],
    ];
    
    protected array $globalSearch = [
        'columns' => ['name'],
        'relations' => [
            'locations.address' => ['city', 'province', 'country', 'street', 'street_number', 'zip'],
        ],
    ];

    protected function select(): array
    {
        return ['id', 'name', 'mine', 'created_at', 'updated_at'];
    }

    /**
     * Display all customers.
     */
    public function index(IndexCustomerRequest $request): JsonResponse
    {   
        return parent::baseIndex($request);
    }

    /**
     * Store a new customer.
     */
    public function store(StoreCustomerRequest $request): JsonResponse
    {
        return parent::baseStore($request);
    }

    /**
     * Display the specified customer.
     */
    public function show(int $id): JsonResponse
    {
        return parent::baseShow($id);
    }
    /**
     * Update the specified customer.
     */
    public function update(UpdateCustomerRequest $request, int $id): JsonResponse
    {
        return parent::baseUpdate($request, $id);
    }

    /**
     * Remove the specified customer.
     */
    public function destroy(int $id): JsonResponse
    {
        return parent::baseDestroy($id);
    }
}
