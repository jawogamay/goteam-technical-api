<?php

use App\Http\API\Controllers\AuthController;
use App\Http\API\Controllers\TaskController;
use App\Http\API\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/test', function() {
    return "Server worked";
});
Route::controller(AuthController::class)->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResources([
        'tasks' => TaskController::class
    ]);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [UserController::class, 'me']);
});
