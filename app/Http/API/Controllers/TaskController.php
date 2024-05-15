<?php

namespace App\Http\API\Controllers;

use App\Http\API\Requests\TaskStoreFormRequest;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * @var TaskService
     */
    private $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of tasks
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $tasks = $this->service->getTasks($user_id);
        return $this->jsonResponse($tasks);
    }
    
    /**
     * Store tasks created by user
     * @param TaskStoreFormRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(TaskStoreFormRequest $request)
    {
        $tasks = $this->service->create($request->all());
        return $this->jsonResponse($tasks, 'Task created successfully');
    }

}
