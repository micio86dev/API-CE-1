<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CollectionController extends BaseController
{   
    protected string $primaryModel = Collection::class;
    protected ?string $primaryResource = CollectionResource::class;
    protected ?string $primaryDetailResource = CollectionDetailResource::class;
    protected array $fillableFields = ['name', 'description', 'published_at'];
    protected array $indexRelations = ['books'];
    protected array $detailRelations = ['books'];
    protected array $belongsToManyRelations = [];
    protected array $hasManyRelations = ['books'];
    protected array $hasOneRelations = [];
    protected array $morphOneRelations = [];

    protected function select(): array
    {
        return ['id', 'name', 'description'];
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
    public function update(Request $request, int $collection_id): JsonResponse
    {
        return parent::baseUpdate($request, $collection_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        return parent::baseDestroy($id);
    }
}
