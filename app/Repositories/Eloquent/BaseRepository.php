<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Thin persistence boundary. Controllers and services depend on the interface,
 * so swapping the data source (or adding a cache decorator) touches one binding.
 */
abstract class BaseRepository implements RepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function query(): Builder
    {
        return $this->model->newQuery();
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->query()->get($columns);
    }

    public function paginate(int $perPage = 15, array $filters = [], array $relations = []): LengthAwarePaginator
    {
        return $this->query()
            ->with($relations)
            ->when(method_exists($this->model, 'scopeFilter'), fn (Builder $q) => $q->filter($filters))
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function find(int $id, array $relations = []): ?Model
    {
        return $this->query()->with($relations)->find($id);
    }

    public function findOrFail(int $id, array $relations = []): Model
    {
        return $this->query()->with($relations)->findOrFail($id);
    }

    public function findBy(string $column, mixed $value, array $relations = []): ?Model
    {
        return $this->query()->with($relations)->where($column, $value)->first();
    }

    public function create(array $data): Model
    {
        return $this->query()->create($data);
    }

    public function update(Model $model, array $data): Model
    {
        $model->fill($data)->save();

        return $model->refresh();
    }

    public function delete(Model $model): bool
    {
        return (bool) $model->delete();
    }

    public function bulkDelete(array $ids): int
    {
        return $this->query()->whereIn('id', $ids)->delete();
    }

    public function bulkUpdate(array $ids, array $data): int
    {
        return $this->query()->whereIn('id', $ids)->update($data);
    }
}
