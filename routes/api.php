<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::post('register', [AuthController::class, 'register']);
Route::post('verify', [AuthController::class, 'verifyOtp']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('user', [AuthController::class, 'user'])->middleware('auth:sanctum');

Route::get('user-id', [AuthController::class, 'getUserId'])->middleware('auth:sanctum');
Route::put('updateProfile', [AuthController::class, 'updateProfile'])->middleware('auth:sanctum');
Route::put('changePassword', [AuthController::class, 'changePassword'])->middleware('auth:sanctum');
Route::put('forgotPassword', [AuthController::class, 'forgotPassword']);


//Task
Route::post('task', [TaskController::class, 'createTask'])->middleware('auth:sanctum');
Route::get('task', [TaskController::class, 'viewAll'])->middleware('auth:sanctum');
Route::get('myTasks', [TaskController::class, 'myTasks'])->middleware('auth:sanctum');
Route::put('editTask/{id}', [TaskController::class, 'editTask'])->middleware('auth:sanctum');
Route::delete('deleteTask/{id}', [TaskController::class, 'deleteTask'])->middleware('auth:sanctum');


Route::get('taskPaginate', [TaskController::class, 'viewAllPaginate'])->middleware('auth:sanctum');
Route::put('taskStatusUpdate/{id}', [TaskController::class, 'updateStatus'])->middleware('auth:sanctum');
Route::get('tasksWithFilter', [TaskController::class, 'viewAllWithFilter'])->middleware('auth:sanctum');
