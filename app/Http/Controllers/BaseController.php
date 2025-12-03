<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BaseController extends Controller
{
    /** @var class-string<Model> */
    protected string $primaryModel;

    /** @var class-string<JsonResource>|null */
    protected ?string $primaryResource = null;

    /** @var class-string<JsonResource>|null */
    protected ?string $primaryDetailResource = null;

    /**
     * Fields allowed for create/update on the primary model.
     */
    protected array $fillableFields = [];

    /**
     * Relations to load in index responses.
     */
    protected array $indexRelations = [];

    /**
     * Relations to load in show and after store/update responses.        
     */
    protected array $detailRelations = [];

    /**
     * Many-to-many relations (BelongsToMany / MorphToMany).
     */
    protected array $belongsToManyRelations = [];

    protected array $searcheableFields = [];

    /**
     * hasMany relations.
     */
    protected array $hasManyRelations = [];

    /**
     * hasOne relations.
     */
    protected array $hasOneRelations = [];

    /**
     * morphOne relations.
     */
    protected array $morphOneRelations = [];

    protected array $result = [];
    protected int $status = 400;

    /**
     * GET /resource
     */
    public function baseIndex(FormRequest $request): JsonResponse
    {
        $query = $this->primaryModel::select($this->select());

        if (!empty($this->indexRelations)) {
            $query->with($this->indexRelations);
        }

        $query = $this->customFilters($request, $query);

        $this->result['data'] = $query->paginate($request->perpage);
        $this->status = 200;

        return $this->jsonData();
    }

    protected function customFilters(FormRequest $request, $query) // Query builder class
    {
        foreach ($this->searcheableFields as $searcheableField) {
            # TODO search field logic (switch...
        }

        return $query;
    }

    /**
     * POST /resource
     */
    public function baseStore(FormRequest $request): JsonResponse
    {
        $modelClass = $this->primaryModel;

        /** @var Model $item */
        $item = DB::transaction(function () use ($modelClass, $request) {
            $validated = $request->validated();

            $params = empty($this->fillableFields)
                ? $validated
                : Arr::only($validated, $this->fillableFields);

            /** @var Model $item */
            $item = $modelClass::create($params);

            $this->syncRelations($item, $request);

            return $item->fresh($this->detailRelations ?: $this->indexRelations);
        });

        $this->result['data'] = $item;
        $this->status = 201;

        return $this->jsonData();
    }

    /**
     * GET /resource/{id}
     */
    public function baseShow(int $id): JsonResponse
    {
        $query = $this->primaryModel::select($this->select());

        if (!empty($this->detailRelations)) {
            $query->with($this->detailRelations);
        } elseif (!empty($this->indexRelations)) {
            $query->with($this->indexRelations);
        }

        try {
            $this->result['data'] = $query->findOrFail($id);
            $this->status = 200;
        } catch (Exception $e) {
            $this->result['message'] = __((new $this->primaryModel)->getTable() . '/validation.not_found');
            $this->status = 404;
        }

        return $this->jsonData();
    }

    /**
     * PUT/PATCH /resource/{id}
     */
    public function baseUpdate(FormRequest $request, int $id): JsonResponse
    {
        $modelClass = $this->primaryModel;

        /** @var Model $item */
        $item = DB::transaction(function () use ($modelClass, $request, $id) {
            /** @var Model $item */
            $item = $modelClass::findOrFail($id);

            $validated = $request->validated();

            $params = empty($this->fillableFields)
                ? $validated
                : Arr::only($validated, $this->fillableFields);

            $item->update($params);

            $this->syncRelations($item, $request);

            return $item->fresh($this->detailRelations ?: $this->indexRelations);
        });

        $this->result['data'] = $item;
        $this->status = 200;

        return $this->jsonData();
    }

    /**
     * DELETE /resource/{id}
     */
    public function baseDestroy(int $id): JsonResponse
    {
        $modelClass = $this->primaryModel;
        /** @var Model $item */
        $item = $modelClass::findOrFail($id);
        $item->delete();

        $this->status = 204;
        $this->result = [];

        return $this->jsonData();
    }

    /**
     * Default select fields for queries.
     */
    protected function select(): array
    {
        return ['*'];
    }

    /**
     * JSON response and Resource handling.
     */
    protected function jsonData(): JsonResponse
    {
        if (isset($this->result['data'])) {
            $data = $this->result['data'];

            // paginate
            if ($data instanceof LengthAwarePaginator) {
                if ($this->primaryResource) {
                    $resource = $this->primaryResource::collection($data);
                    return $resource->response()->setStatusCode($this->status);
                }

                return response()->json($data, $this->status);
            }

            // single item
            if ($this->primaryDetailResource) {
                $resource = new $this->primaryDetailResource($data);
                return $resource->response()->setStatusCode($this->status);
            }

            if ($this->primaryResource) {
                $resource = new $this->primaryResource($data);
                return $resource->response()->setStatusCode($this->status);
            }

            return response()->json($data, $this->status);
        }

        return (new JsonResource($this->result))->response()->setStatusCode($this->status);
    }

    /**
     * Synchronizes ONLY the relations explicitly declared
     * in child controllers.
     */
    protected function syncRelations(Model $item, FormRequest $request): void
    {
        // many-to-many (BelongsToMany / MorphToMany)
        foreach ($this->belongsToManyRelations as $relation) {
            if ($request->has($relation)) {
                $ids = $request->input($relation, []);
                $item->$relation()->sync($ids);
            }
        }

        // hasMany: delete + createMany
        foreach ($this->hasManyRelations as $relation) {
            if ($request->has($relation)) {
                $rows = $request->input($relation, []);

                $item->$relation()->delete();

                if (is_array($rows) && !empty($rows)) {
                    $item->$relation()->createMany($rows);
                }
            }
        }

        // hasOne
        foreach ($this->hasOneRelations as $relation) {
            if ($request->has($relation)) {
                $data = $request->input($relation);

                $related = $item->$relation()->first();
                if ($related) {
                    $related->update($data);
                } else {
                    $item->$relation()->create($data);
                }
            }
        }

        // morphOne
        foreach ($this->morphOneRelations as $relation) {
            if ($request->has($relation)) {
                $data = $request->input($relation);

                $related = $item->$relation()->first();
                if ($related) {
                    $related->update($data);
                } else {
                    $item->$relation()->create($data);
                }
            }
        }
    }
}
