<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Resources\AddressResource;
use App\Http\Resources\AddressDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\IndexAddressRequest;

class AddressController extends BaseController
{
    protected string $primaryModel = Address::class;
    protected ?string $primaryResource = AddressResource::class;
    protected ?string $primaryDetailResource = AddressDetailResource::class;
    protected array $fillableFields = ['city', 'province', 'country', 'street', 'street_number', 'zip', 'lat', 'lng'];
    protected array $indexRelations = [];
    protected array $detailRelations = [];
    protected array $belongsToManyRelations = [];
    protected array $hasManyRelations = [];
    protected array $hasOneRelations = ['model'];
    protected array $morphOneRelations = [];
    protected array $searchableFields = [
        
        'equal' => [
            'city',
            'province',
            'country',
            'street',
            'street_number',
            'zip',
        ],
        'like' => [
            'city',
            'province',
            'country',
            'street',
            'street_number',
        ],
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
     * Display all addresses.
     */
    public function index(IndexAddressRequest $request): JsonResponse
    {
        return parent::baseIndex($request);
    }

    /**
     * Store a new address.
     */
    public function store(Request $request): JsonResponse
    {
        return parent::baseStore($request);
    }

    /**
     * Display the specified address.
     */
    public function show(int $id): JsonResponse
    {
        return parent::baseShow($id);
    }

    /**
     * Update the specified address.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        return parent::baseUpdate($request, $id);
    }

    /**
     * Remove the specified address.
     */
    public function destroy(int $id): JsonResponse
    {
        return parent::baseDestroy($id);
    }
}
