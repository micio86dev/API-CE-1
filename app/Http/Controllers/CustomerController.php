<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CustomerController extends BaseController
{   
    protected string $primaryModel = Customer::class;
    protected ?string $primaryResource = CustomerResource::class;
    protected ?string $primaryDetailResource = CustomerDetailResource::class;
    protected array $fillableFields = ['name', 'email', 'phone', 'address'];
    protected array $indexRelations = ['locations'];
    protected array $detailRelations = ['locations'];
    protected array $belongsToManyRelations = [];
    protected array $hasManyRelations = ['locations'];
    protected array $hasOneRelations = [];
    protected array $morphOneRelations = [];

    protected function select(): array
    {
        return ['id', 'name', 'email', 'phone', 'address', 'created_at', 'updated_at'];
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
    public function store(Request $request): JsonResponse
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
    public function update(Request $request, int $id): JsonResponse
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
