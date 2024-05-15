<?php

namespace App\Services;

use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class EloquentService implements EloquentServiceInterface
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    abstract public function model(): string;

    /**
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;

        $this->repository->setModel($this->model());
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->repository->all();
    }

    /**
     * @return Paginator
     */
    public function paginate(): Paginator
    {
        return $this->repository->paginate();
    }

    /**
     * @param $id
     * @return Model|null
     */
    public function find($id): ?Model
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return Model|null
     */
    public function create(array $data): ?Model
    {
        return $this->repository->create($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data): bool
    {
        $data = array_filter($data, function ($value) {
            return ! is_null($value);
        });

        return $this->find($id)->fill($data)->save();
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function delete($id): bool
    {
        return $this->find($id)->delete();
    }

    /**
     * @param $service
     * @return EloquentServiceInterface
     */
    public function getService($service): EloquentServiceInterface
    {
        return app($service);
    }
}