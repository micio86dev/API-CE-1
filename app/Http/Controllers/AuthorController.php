<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\IndexAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Resources\AuthorDetailResource;
use App\Http\Resources\AuthorResource;
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
    protected array $searchableFields = [
        'equal' => [
            'age',
        ],
        'like' => [
            'first_name',
            'last_name',
        ],
    ];

    protected function select(): array
    {
        return ['id', 'first_name', 'last_name', 'created_at', 'updated_at'];
    }

    /**
     * Display all authors.
     */
    public function index(IndexAuthorRequest $request): JsonResponse
 
    {
        return parent::baseIndex($request);
    }

    /**
     * Store a new author.
     */
    public function store(StoreAuthorRequest $request): JsonResponse
    {
        return parent::baseStore($request);
    }

    /**
     * Display the specified author.
     */
    public function show(int $id): JsonResponse
    {
        return parent::baseShow($id);
    }

    /**
     * Update the specified author.
     */
    public function update(UpdateAuthorRequest $request, int $id): JsonResponse
    {
        return parent::baseUpdate($request, $id);
    }

    /**
     * Remove the specified author.
     */
    public function destroy(int $id): JsonResponse
    {
        return parent::baseDestroy($id);
    }
}
