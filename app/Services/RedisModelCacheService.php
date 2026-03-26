<?php

namespace App\Services;

use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class RedisModelCacheService
{
    protected string $ttlStore = 'ttl';

    public function __construct(
        protected ModelRelationSerializer $serializer
    ) {
    }

    public function getOrRememberShow(
        string $modelClass,
        int|string $id,
        array $relations,
        int $ttl,
        Closure $resolver
    ): ?Model {
        $cacheKey = $this->showKey($modelClass, $id, $relations);
        $cached = Cache::store($this->ttlStore)->get($cacheKey);

        if (is_array($cached) && !empty($cached['class']) && array_key_exists('id', $cached)) {
            $hydrated = $this->serializer->hydrateModel($cached['class'], $cached['id']);
            if ($hydrated instanceof Model) {
                return $hydrated;
            }

            Cache::store($this->ttlStore)->forget($cacheKey);
        }

        $model = $resolver();

        if (!($model instanceof Model)) {
            return null;
        }

        $this->serializer->persistModelGraph($model);
        Cache::store($this->ttlStore)->put($cacheKey, $this->serializer->makeTtlPayload($model), $ttl);
        $this->rememberKey($this->showRefKey($modelClass, $id), $cacheKey);

        return $model;
    }

    public function getOrRememberIndex(
        string $modelClass,
        array $filters,
        array $relations,
        int $page,
        int $perPage,
        int $ttl,
        Closure $resolver
    ): LengthAwarePaginator {
        $cacheKey = $this->indexKey($modelClass, $filters, $page, $perPage);
        $cached = Cache::store($this->ttlStore)->get($cacheKey);

        if (is_array($cached)) {
            $hydrated = $this->hydratePaginator($cached);
            if ($hydrated instanceof LengthAwarePaginator) {
                return $hydrated;
            }

            Cache::store($this->ttlStore)->forget($cacheKey);
        }

        /** @var LengthAwarePaginator $paginator */
        $paginator = $resolver();
        $items = $paginator->getCollection();

        foreach ($items as $item) {
            if ($item instanceof Model) {
                $this->serializer->persistModelGraph($item);
            }
        }

        $payload = [
            'items' => $this->serializer->makeTtlCollectionPayload($items),
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'path' => $paginator->path(),
            'page_name' => $paginator->getPageName(),
            'query' => $paginator->getOptions()['query'] ?? [],
        ];

        Cache::store($this->ttlStore)->put($cacheKey, $payload, $ttl);
        $this->rememberKey($this->indexRefKey($modelClass), $cacheKey);

        return $paginator;
    }

    public function refreshAfterWrite(
        string $modelClass,
        int|string|null $id,
        ?Model $freshModel = null,
        array $relations = [],
        ?int $showTtl = null
    ): void
    {
        if ($id !== null) {
            $showRefKey = $this->showRefKey($modelClass, $id);
            $this->flushTrackedKeys($showRefKey);
            Cache::store($this->ttlStore)->forget($showRefKey);
            Cache::store('persistent')->forget($this->entityKey($modelClass, $id));
        }

        $this->flushModelIndexKeys($modelClass);

        if ($id !== null && $freshModel instanceof Model) {
            $this->serializer->persistModelGraph($freshModel);

            $cacheKey = $this->showKey($modelClass, $id, $relations);
            Cache::store($this->ttlStore)->put(
                $cacheKey,
                $this->serializer->makeTtlPayload($freshModel),
                $showTtl ?? 300
            );
            $this->rememberKey($this->showRefKey($modelClass, $id), $cacheKey);
        }
    }

    public function flushModelIndexKeys(string $modelClass): void
    {
        $refKey = $this->indexRefKey($modelClass);
        $this->flushTrackedKeys($refKey);
        Cache::store($this->ttlStore)->forget($refKey);
    }

    protected function hydratePaginator(array $payload): ?LengthAwarePaginator
    {
        $itemMeta = $payload['items'] ?? [];
        if (!is_array($itemMeta)) {
            return null;
        }

        $models = [];

        foreach ($itemMeta as $meta) {
            if (!is_array($meta) || empty($meta['class']) || !array_key_exists('id', $meta)) {
                return null;
            }

            $model = $this->serializer->hydrateModel($meta['class'], $meta['id']);
            if (!($model instanceof Model)) {
                return null;
            }

            $models[] = $model;
        }

        return new \Illuminate\Pagination\LengthAwarePaginator(
            new EloquentCollection($models),
            (int) ($payload['total'] ?? 0),
            max(1, (int) ($payload['per_page'] ?? 10)),
            max(1, (int) ($payload['current_page'] ?? 1)),
            [
                'path' => (string) ($payload['path'] ?? '/'),
                'pageName' => (string) ($payload['page_name'] ?? 'page'),
                'query' => is_array($payload['query'] ?? null) ? $payload['query'] : [],
            ]
        );
    }

    protected function rememberKey(string $refKey, string $cacheKey): void
    {
        $keys = Cache::store($this->ttlStore)->get($refKey, []);

        if (!is_array($keys)) {
            $keys = [];
        }

        if (!in_array($cacheKey, $keys, true)) {
            $keys[] = $cacheKey;
            Cache::store($this->ttlStore)->forever($refKey, $keys);
        }
    }

    protected function flushTrackedKeys(string $refKey): void
    {
        $keys = Cache::store($this->ttlStore)->get($refKey, []);

        if (!is_array($keys) || empty($keys)) {
            return;
        }

        foreach ($keys as $key) {
            if (is_string($key) && $key !== '') {
                Cache::store($this->ttlStore)->forget($key);
            }
        }
    }

    protected function showKey(string $modelClass, int|string $id, array $relations = []): string
    {
        $locale = app()->getLocale();
        $alias = $this->modelAlias($modelClass);
        $signature = sha1(json_encode($this->normalizeRelations($relations), JSON_THROW_ON_ERROR));

        return "v1:api:{$alias}:{$id}:show:{$locale}:{$signature}";
    }

    protected function indexKey(string $modelClass, array $filters, int $page, int $perPage): string
    {
        $locale = app()->getLocale();
        $alias = $this->modelAlias($modelClass);

        $normalizedFilters = $this->normalizeArray($filters);
        $hash = sha1(json_encode([
            'filters' => $normalizedFilters,
            'page' => $page,
            'per_page' => $perPage,
            'locale' => $locale,
        ], JSON_THROW_ON_ERROR));

        return "v1:api:{$alias}:index:{$hash}";
    }

    protected function showRefKey(string $modelClass, int|string $id): string
    {
        $alias = $this->modelAlias($modelClass);
        return "v1:show_refs:{$alias}:{$id}";
    }

    protected function indexRefKey(string $modelClass): string
    {
        $alias = $this->modelAlias($modelClass);
        return "v1:index_refs:{$alias}";
    }

    protected function entityKey(string $modelClass, int|string $id): string
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

    protected function normalizeArray(array $value): array
    {
        foreach ($value as $key => $item) {
            if (is_array($item)) {
                $value[$key] = $this->normalizeArray($item);
            }
        }

        if ($this->isAssoc($value)) {
            ksort($value);
        }

        return $value;
    }

    protected function normalizeRelations(array $relations): array
    {
        $normalized = array_values(array_unique(array_filter(
            array_map(static fn ($relation) => is_string($relation) ? trim($relation) : '',
                $relations),
            static fn (string $relation) => $relation !== ''
        )));

        sort($normalized);

        return $normalized;
    }

    protected function isAssoc(array $array): bool
    {
        if ($array === []) {
            return false;
        }

        return array_keys($array) !== range(0, count($array) - 1);
    }
}
