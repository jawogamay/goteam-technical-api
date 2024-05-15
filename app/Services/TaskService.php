<?php

namespace App\Services;

use App\Models\Task;
use App\Services\EloquentService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskService extends EloquentService {
    public function model(): string
    {
        return Task::class;
    }

      /**
     * @param array $data
     * @return Model|null
     * @throws Exception
     */

     public function create(array $data): ?Model
     {
         try {
             DB::beginTransaction();
             $task = $this->repository->setModel($this->model())->factory($data);
             $task->user_id = Auth::user()->id;
             $task->save();
             DB::commit();
             return $task;
         } catch (Exception $exception) {
             DB::rollBack();
             throw $exception;
         }
     }

     /**
      * @param user_id
      * @return Collection|null
      */
     public function getTasks($user_id): ?Collection
     {
        try {
            DB::beginTransaction();
            $query = $this->repository->setModel($this->model())->newQuery();
            $tasks = $query->where('user_id', $user_id)->with('status')->get();
            DB::commit();
            return $tasks;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
     }
 
}