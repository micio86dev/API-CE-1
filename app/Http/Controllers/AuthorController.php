<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Resources\AuthorDetailResource;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthorController extends BaseController
{   
    protected string $primaryModel = Author::class;
    protected ?string $primaryResource = AuthorResource::class;
    protected ?string $primaryDetailResource = AuthorDetailResource::class;
    protected array $fillableFields = ['first_name', 'last_name', 'created_at', 'updated_at'];
    protected array $indexRelations = ['books'];
    protected array $detailRelations = ['books'];
    protected array $belongsToManyRelations = ['books'];
    protected array $hasManyRelations = [];
    protected array $hasOneRelations = [];

    protected function select(): array
    {
        return ['id', 'first_name', 'last_name', 'created_at', 'updated_at'];
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
    public function store(StoreAuthorRequest $request): JsonResponse
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
    public function update(UpdateAuthorRequest $request, int $id): JsonResponse
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
