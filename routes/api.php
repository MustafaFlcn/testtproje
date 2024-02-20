<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TasksController;




Route::post('/login', [AuthController::class, 'login']);


Route::post('/user/register', [AuthController::class, 'register']);

Route::put('/user/update/{id}', [AuthController::class, 'Update']);

Route::delete('/users/soft-delete/{id}', [AuthController::class, 'softDelete']);

Route::delete('/users/hard-delete/{id}', [AuthController::class, 'hardDelete']);





Route::group(["middleware"=>"auth:sanctum"],function () {

    Route::post('/tasks/add', [TasksController::class, 'addTask']);

    Route::put('/tasks/update/{id}', [TasksController::class, 'updateTask']);

    Route::delete('/tasks/soft-delete/{id}', [TasksController::class, 'softDelete']);

    Route::delete('/tasks/hard-delete/{id}', [TasksController::class, 'hardDelete']);

    Route::post('/logout', [AuthController::class, 'logout']);

});
