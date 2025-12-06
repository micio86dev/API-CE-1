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
    protected string $primaryModel = Type::class;
    protected ?string $primaryResource = TypeResource::class;
    protected ?string $primaryDetailResource = TypeDetailResource::class;
    protected array $fillableFields = ['name', 'alias'];
    protected array $indexRelations = ['books', 'locations'];
    protected array $detailRelations = ['books', 'locations'];
    protected array $belongsToManyRelations = ['books', 'locations'];
    protected array $hasManyRelations = [];
    protected array $hasOneRelations = [];
    protected array $morphOneRelations = [];

    protected function select(): array
    {
        return ['id', 'name', 'alias', 'created_at', 'updated_at'];
    }
    /**
     * Display all types.
     */
    public function index(): JsonResponse
    {
        return parent::baseIndex();
    }

    /**
     * Store a new type.
     */
    public function store(StoreTypeRequest $request): JsonResponse
    {
        return parent::baseStore($request);
    }

    /**
     * Display the specified type.
     */
    public function show(int $id): JsonResponse
    {
        return parent::baseShow($id);
    }

    /**
     * Update the specified type.
     */
    public function update(UpdateTypeRequest $request, int $id): JsonResponse
    {
        return parent::baseUpdate($request, $id);
    }

    /**
     * Remove the specified type.
     */
    public function destroy(int $id): JsonResponse
    {
        return parent::baseDestroy($id);
    }
}
