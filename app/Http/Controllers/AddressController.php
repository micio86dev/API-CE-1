<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Resources\AddressResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AddressController extends BaseController
{
    protected $primaryModel = Address::class;
    protected $primaryResource = AddressResource::class;
    protected $primaryDetailResource = AddressResource::class;
    protected $primaryRequest = StoreAddressRequest::class;
    protected  array $addModFields = [
        'city',
        'province',
        'country',
        'street',
        'street_number',
        'zip',
        'lat',
        'lng',
    ];

    protected function select(): array
    {
        return [
            'id',
            'city',
            'province',
            'country',
            'street',
            'street_number',
            'zip',
            'lat',
            'lng',
        ];
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
