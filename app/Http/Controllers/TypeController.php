<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Http\Resources\TypeDetailResource;
use App\Http\Resources\TypeResource;
use Illuminate\Http\JsonResponse;

class TypeController extends BaseController
{   
    protected $primaryModel = Type::class;
    protected $primaryResource = TypeResource::class;
    protected $primaryDetailResource = TypeDetailResource::class;
    protected array $addModFields = ['name', 'alias'];

    protected function select(): array
    {
        return ['id', 'name', 'alias'];
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
    public function store(StoreTypeRequest $request): JsonResponse
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
    public function update(UpdateTypeRequest $request, int $id): JsonResponse
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
