<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;


class UserController extends BaseController
{
    protected string $primaryModel = User::class;
    protected ?string $primaryResource = null; //ToDo: create UserResource
    protected ?string $primaryDetailResource = null;
    protected array $fillableFields = ['name', 'email', 'password'];
    protected array $indexRelations = [];
    protected array $detailRelations = [];
    protected array $belongsToManyRelations = [];
    protected array $hasManyRelations = [];
    protected array $hasOneRelations = [];
    protected array $morphOneRelations = [];

    protected function select(): array
    {
        return ['id', 'name', 'email', 'password', 'created_at', 'updated_at'];
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
    public function store(StoreUserRequest $request): JsonResponse
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
    public function update(UpdateUserRequest $request, int $id): JsonResponse
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
