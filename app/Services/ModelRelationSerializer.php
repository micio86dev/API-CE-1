<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ModelRelationSerializer
{
    protected string $persistentStore = 'persistent';

    public function persistModelGraph(Model $model): void
    {
        $visited = [];
        $this->persistRecursive($model, $visited);
    }

    public function makeTtlPayload(Model $model): array
    {
        return [
            'class' => $model::class,
            'id' => $model->getKey(),
        ];
    }

    public function makeTtlCollectionPayload(Collection|EloquentCollection $models): array
    {
        return $models
            ->filter(fn ($model) => $model instanceof Model)
            ->map(fn (Model $model) => $this->makeTtlPayload($model))
            ->values()
            ->all();
    }

    public function hydrateModel(string $modelClass, mixed $id): ?Model
    {
        $entity = Cache::store($this->persistentStore)->get($this->entityKey($modelClass, $id));

        if (!is_array($entity) || empty($entity['class'])) {
            return null;
        }

        $hydrating = [];

        return $this->hydrateEntity($entity, $hydrating);
    }

    protected function persistRecursive(Model $model, array &$visited): void
    {
        $entityKey = $this->entityKey($model::class, $model->getKey());

        if (isset($visited[$entityKey])) {
            return;
        }

        $visited[$entityKey] = true;

        $payload = [
            'class' => $model::class,
            'id' => $model->getKey(),
            'attributes' => $model->getAttributes(),
            'relations' => [],
        ];

        foreach ($model->getRelations() as $relationName => $relationValue) {
            if ($relationValue instanceof Model) {
                $payload['relations'][$relationName] = [
                    'type' => 'one',
                    'class' => $relationValue::class,
                    'ids' => [$relationValue->getKey()],
                ];

                $this->persistRecursive($relationValue, $visited);
            } elseif ($relationValue instanceof EloquentCollection) {
                $ids = [];
                $relationClass = null;

                foreach ($relationValue as $relatedModel) {
                    if (!($relatedModel instanceof Model)) {
                        continue;
                    }

                    $ids[] = $relatedModel->getKey();
                    $relationClass ??= $relatedModel::class;
                    $this->persistRecursive($relatedModel, $visited);
                }

                $payload['relations'][$relationName] = [
                    'type' => 'many',
                    'class' => $relationClass,
                    'ids' => $ids,
                ];
            }
        }

        Cache::store($this->persistentStore)->forever($entityKey, $payload);
    }

    protected function hydrateEntity(array $entity, array &$hydrating): ?Model
    {
        $modelClass = $entity['class'] ?? null;

        if (!is_string($modelClass) || !class_exists($modelClass)) {
            return null;
        }

        if (!is_subclass_of($modelClass, Model::class)) {
            return null;
        }

        $id = $entity['id'] ?? null;
        $stateKey = $this->entityKey($modelClass, $id);

        if (isset($hydrating[$stateKey])) {
            return $this->instantiateModel($modelClass, $entity['attributes'] ?? []);
        }

        $hydrating[$stateKey] = true;
        $model = $this->instantiateModel($modelClass, $entity['attributes'] ?? []);

        foreach (($entity['relations'] ?? []) as $relationName => $relationMeta) {
            if (!is_array($relationMeta) || empty($relationMeta['class'])) {
                continue;
            }

            $relationType = $relationMeta['type'] ?? 'many';
            $relationClass = $relationMeta['class'];
            $ids = array_values(array_filter((array) ($relationMeta['ids'] ?? []), fn ($value) => $value !== null));

            if ($relationType === 'one') {
                $firstId = $ids[0] ?? null;
                if ($firstId === null) {
                    continue;
                }

                $relatedEntity = Cache::store($this->persistentStore)->get($this->entityKey($relationClass, $firstId));
                if (!is_array($relatedEntity)) {
                    continue;
                }

                $relatedModel = $this->hydrateEntity($relatedEntity, $hydrating);
                if ($relatedModel instanceof Model) {
                    $model->setRelation($relationName, $relatedModel);
                }

                continue;
            }

            $relatedModels = [];

            foreach ($ids as $relationId) {
                $relatedEntity = Cache::store($this->persistentStore)->get($this->entityKey($relationClass, $relationId));
                if (!is_array($relatedEntity)) {
                    continue;
                }

                $relatedModel = $this->hydrateEntity($relatedEntity, $hydrating);
                if ($relatedModel instanceof Model) {
                    $relatedModels[] = $relatedModel;
                }
            }

            $model->setRelation($relationName, new EloquentCollection($relatedModels));
        }

        unset($hydrating[$stateKey]);

        return $model;
    }

    protected function instantiateModel(string $modelClass, array $attributes): Model
    {
        /** @var Model $model */
        $model = new $modelClass();
        $model->setRawAttributes($attributes, true);
        $model->exists = true;
        $model->wasRecentlyCreated = false;

        return $model;
    }

    protected function entityKey(string $modelClass, mixed $id): string
    {
        $alias = $this->modelAlias($modelClass);
        return "v1:entity:{$alias}:{$id}";
    }

    protected function modelAlias(string $modelClass): string
    {
        if (class_exists($modelClass) && is_subclass_of($modelClass, Model::class)) {
            /** @var Model $instance */
            $instance = new $modelClass();
            return $instance->getTable();
        }

        return strtolower(class_basename($modelClass));
    }
}
