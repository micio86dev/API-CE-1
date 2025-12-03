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

    protected function select(): array
    {
        return ['id', 'name', 'phone_number', 'email', 'customer_id', 'created_at', 'updated_at'];
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
    public function store(StoreLocationRequest $request): JsonResponse
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
    public function update(UpdateLocationRequest $request, int $id): JsonResponse
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
