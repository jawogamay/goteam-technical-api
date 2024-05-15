<?php

use App\Models\User;
use App\Services\EloquentService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserService extends EloquentService {
    public function model(): string
    {
        return User::class;
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
             $item = $this->repository->setModel($this->model())->factory($data);
             $item->save();
             DB::commit();
             return $item;
         } catch (Exception $exception) {
             DB::rollBack();
             throw $exception;
         }
     }
 
}