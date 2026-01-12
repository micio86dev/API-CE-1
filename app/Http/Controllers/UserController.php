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
    protected ?string $primaryResource = UserResource::class;
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
     * Display all users.
     */
    public function index(): JsonResponse
    {
        return parent::baseIndex();
    }

    /**
     * Store a new user.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        return parent::baseStore($request);
    }

    /**
     * Display the specified user.
     */
    public function show(int $id): JsonResponse
    {
        return parent::baseShow($id);
    }

    /**
     * Update the specified user.
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        return parent::baseUpdate($request, $id);

    }

    /**
     * Remove the specified user.
     */
    public function destroy(int $id): JsonResponse
    {
        return parent::baseDestroy($id);
    }
}
