<?php

/*
 * Copyright (C) Technoplus, Lda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */

namespace App\Repositories;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function factory(array $data): Model;

    /**
     * Set model for the repository.
     *
     * @param $model
     *
     * @return self
     */
    public function setModel($model): self;

    /**
     * Get current repository model.
     *
     * @return Model
     */
    public function getModel(): Model;

    public function all($columns = ['*']): Collection;

    /**
     * @param array | string $columns
     * @return Paginator
     */
    public function paginate($columns = ['*']): Paginator;

    /**
     * @param $id
     *
     * @param array | string $columns
     * @return Model
     */
    public function find($id, $columns = ['*']): ?Model;

    public function create(array $data): ?Model;

    /**
     * @param $data
     * @param $id
     *
     * @return bool
     */
    public function update($id, array $data): bool;

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool;

    public function newQuery(): Builder;
}