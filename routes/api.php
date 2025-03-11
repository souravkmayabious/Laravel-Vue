<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;

Route::post('register', [AuthController::class, 'register']);
Route::post('verify', [AuthController::class, 'verifyOtp']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('user', [AuthController::class, 'user'])->middleware('auth:sanctum');

Route::get('user-id', [AuthController::class, 'getUserId'])->middleware('auth:sanctum');
Route::put('updateProfile', [AuthController::class, 'updateProfile'])->middleware('auth:sanctum');
Route::put('changePassword', [AuthController::class, 'changePassword'])->middleware('auth:sanctum');
Route::put('forgotPassword', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);


Route::post('update-profile-image', [ProfileController::class, 'updateProfileImage'])->middleware('auth:sanctum');
Route::delete('delete-profile-image', [ProfileController::class, 'deleteProfileImage'])->middleware('auth:sanctum');
Route::delete('deleteUser', [ProfileController::class, 'deleteUser'])->middleware('auth:sanctum');

//Task
Route::post('task', [TaskController::class, 'createTask'])->middleware('auth:sanctum');
Route::get('task', [TaskController::class, 'viewAll'])->middleware('auth:sanctum');
Route::get('myTasks', [TaskController::class, 'myTasks'])->middleware('auth:sanctum');
Route::put('editTask/{id}', [TaskController::class, 'editTask'])->middleware('auth:sanctum');
Route::delete('deleteTask/{id}', [TaskController::class, 'deleteTask'])->middleware('auth:sanctum');


Route::get('taskPaginate', [TaskController::class, 'viewAllPaginate'])->middleware('auth:sanctum');
Route::put('taskStatusUpdate/{id}', [TaskController::class, 'updateStatus'])->middleware('auth:sanctum');
Route::get('tasksWithFilter', [TaskController::class, 'viewAllWithFilter'])->middleware('auth:sanctum');

Route::post('create-user',[UserController::class , 'addUser'])->middleware('auth:sanctum');
Route::get('account-list',[UserController::class , 'accountList'])->middleware('auth:sanctum');



Route::post('/upload/local', [FileController::class, 'uploadLocal']);
Route::post('/upload/cloudinary', [FileController::class, 'uploadCloudinary']);