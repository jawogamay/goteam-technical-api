<?php

use App\Models\Status;
use App\Services\EloquentService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StatusService extends EloquentService {
    public function model(): string
    {
        return Status::class;
    }

      /**
     * @param array $data
     * @return Model|null
     * @throws Exception
     */

     public function findStatus($id): ?Model
     {
         try {
             DB::beginTransaction();
             $status = $this->repository->setModel($this->model())->find($id);
             DB::commit();
             return $status;
         } catch (Exception $exception) {
             DB::rollBack();
             throw $exception;
         }
     }
 
}