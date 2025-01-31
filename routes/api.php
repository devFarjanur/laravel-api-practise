<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/get-user', [UserController::class, 'getUser']);
Route::post('/post-user', [UserController::class, 'storeUser']);
Route::get('/find-user/{id}', [UserController::class, 'findUser']);
Route::put('/update-user/{id}', [UserController::class, 'updateUser']);
Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);
