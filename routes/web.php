<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// API User
Route::post('/api/user/signUp', [UserController::class, 'signUp']);
Route::post('/api/user/login', [UserController::class, 'login']);
Route::post('/api/user/logout', [UserController::class, 'logout']);
Route::get('/api/user/data', [UserController::class, 'user']);

Route::get('/api/user/verify-email/{id}', [UserController::class, 'verifyEmail']);
Route::post('/api/user/setPassword/{id}', [UserController::class, 'setPassword']);
