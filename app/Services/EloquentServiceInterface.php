<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentServiceInterface
{
    public function all(): Collection;

    public function paginate(): Paginator;

    public function find($id): ?Model;

    public function create(array $data): ?Model;

    public function update($id, array $data): bool;

    public function delete($id): bool;

    public function model(): string;

    public function getService($service): self;
}