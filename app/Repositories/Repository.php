<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    public function factory(array $data): Model
    {
        $model = $this->getModel()->newInstance();
        $model->fill($data);

        return $model;
    }

    /**
     * Set model for the repository.
     *
     * @param string | Model $model
     *
     * @return self
     */
    public function setModel($model): RepositoryInterface
    {
        if (is_string($model)) {
            $model = new $model();
        }
        $this->model = $model;

        return $this;
    }

    /**
     * Get current repository model.
     *
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    public function all($columns = ['*']): Collection
    {
        return $this->newQuery()->get($columns = ['*']);
    }

    /**
     * @param array | string $columns
     * @return Paginator
     */
    public function paginate($columns = ['*']): Paginator
    {
        return $this->newQuery()->paginate(null, $columns = ['*']);
    }

    /**
     * @param $id
     *
     * @param array | string $columns
     * @return Model
     */
    public function find($id, $columns = ['*']): ?Model
    {
        return $this->newQuery()->findOrFail($id, $columns);
    }

    public function create(array $data): ?Model
    {
        $model = $this->factory($data);
        $model->save();

        return $model;
    }

    /**
     * @param $data
     * @param $id
     *
     * @return bool
     */
    public function update($id, array $data): bool
    {
        return $this
            ->newQuery()
            ->findOrFail($id)
            ->fill($data)
            ->save();
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        return $this->newQuery()->findOrFail($id)->delete();
    }

    public function newQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->newQuery();
    }
}