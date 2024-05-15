<?php

namespace App\Http\API\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskStoreFormRequest extends FormRequest
{
    public function rules()
    {
        return [
          'title' => 'required',
          'user_id' => 'required|exists:user,id',
          'description' => 'required',
          'due_date' => 'required',
          'status_id' => 'required|exists:status,id'
        ];
    }
}