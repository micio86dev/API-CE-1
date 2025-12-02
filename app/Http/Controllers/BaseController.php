<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
/*asdasd*/
class BaseController extends Controller
{
    protected $result = [];
    protected $status = 400;
    protected $primaryModel;
    protected $primaryResource;
    protected $primaryDetailResource;
    protected array $relations = [];
    protected array $relationTypes = [];
    protected array $detailRelations = [];
    protected array $addModFields = [];

    /**
     * Display a listing of the resource.
     */
    public function baseIndex(): JsonResponse
    {
        $this->getRelations();
        $query = $this->primaryModel::select($this->select());

        if (!empty($this->relations)) {
            $query->with($this->relations);
        }

        $this->result['data'] = $query->paginate();
        $this->status = 200;

        return $this->jsonData();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function baseStore(FormRequest $request): JsonResponse
    {
        $this->getRelations();

        $params = Arr::only($request->validated(), $this->addModFields);
        $item = $this->primaryModel::create($params);

        $this->syncRelations($item, $request);

        $this->result['data'] = $item->refresh();
        $this->status = 201;

        return $this->jsonData();
    }

    /**
     * Display the specified resource.
     */
    public function baseShow(int $id): JsonResponse
    {
        $query = $this->primaryModel::select($this->select());

        if (!empty($this->detailRelations)) {
            $query->with($this->detailRelations);
        } elseif (!empty($this->relations)) {
            $query->with($this->relations);
        }

        $this->result['data'] = $query->findOrFail($id);
        $this->status = 200;

        return $this->jsonData();
    }

    /**
     * Update the specified resource in storage.
     */
    public function baseUpdate(FormRequest $request, int $id): JsonResponse
    {
        $this->getRelations();

        $params = Arr::only($request->validated(), $this->addModFields);
        $item = $this->primaryModel::findOrFail($id);
        $item->update($params);

        $this->syncRelations($item, $request);

        $this->result['data'] = $item->refresh();
        $this->status = 200;

        return $this->jsonData();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function baseDestroy(int $id): JsonResponse
    {
        $this->primaryModel::where('id', $id)->delete();
        $this->status = 204;
        return $this->jsonData();
    }

    /**
     * Sync many-to-many relationships
     */
    protected function syncRelations($item, FormRequest $request): void
    {
        foreach ($this->relations as $relationName) {
            if (!$request->has($relationName) || in_array($relationName, $this->addModFields)) {
                continue;
            }

            $relationType = $this->relationTypes[$relationName];

            $relationSingleModels = [
                MorphOne::class,
                BelongsTo::class,
            ];

            $relationManyModels = [
                BelongsToMany::class,
                MorphToMany::class,
                HasMany::class,
                HasManyThrough::class,
            ];

            if (in_array($relationType['class'], $relationManyModels)) {
                $item->$relationName()->sync($request->input($relationName, []));
            }
            if (in_array($relationType['class'], $relationSingleModels)) {
                $params = $request->input($relationName);
                $params['model_type'] = $item::class;
                $params['model_id'] = $item->id;
                $relationModel = $relationType['model']::class;
                $relationModel::create($params);
            }
            
        }
    }

    protected function jsonData(): JsonResponse
    {
        if (isset($this->result['data'])) {
            $data = $this->result['data'];

            if ($data instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) {
                if ($this->primaryResource) {
                    $resource = $this->primaryResource::collection($data);
                    return $resource->response()->setStatusCode($this->status);
                }
            } else {
                if ($this->primaryDetailResource) {
                    $resource = new $this->primaryDetailResource($data);
                    return $resource->response()->setStatusCode($this->status);
                }
            }
        }

        return (new JsonResource($this->result))->response()->setStatusCode($this->status);
    }

    protected function select(): array
    {
        return ['id'];
    }

    protected function getRelations(): array
    {
        if (!empty($this->relations)) {
            return $this->relations;
        }

        $model = new $this->primaryModel;
        $reflection = new \ReflectionClass($model);
        $this->relations = [];
        $this->relationTypes = [];

        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->class === get_class($model) && $method->getNumberOfParameters() === 0) {
                try {
                    $result = $method->invoke($model);

                    if ($result instanceof \Illuminate\Database\Eloquent\Relations\Relation) {
                        $relationName = $method->getName();
                        $this->relations[] = $relationName;
                        $related = $result->getRelated();
                        $this->relationTypes[$relationName] = ['class' => get_class($result), 'model' => $related];
                    }
                } catch (\Throwable $e) {
                    continue;
                }
            }
        }

        return $this->relations;
    }

    protected function addRelations($modifications)
    {
        $array = $this->relations;

        foreach ($modifications as $searchFor => $appendText) {
            foreach ($array as $key => $value) {
                if ($value === $searchFor) {
                    $array[$key] = $value . $appendText;
                    break;
                }
            }
        }

        return $array;
    }
}
