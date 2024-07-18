<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\CategoryController;

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::get('/forget-password',[AuthController::class,'forgetPassword']);

Route::middleware('api-auth')->group(function () {
    Route::post('/logout',[AuthController::class,'logout']);

    Route::apiResource('/notes',NoteController::class);
    Route::patch('/notes/{note}/favorite',[NoteController::class,'favorite']);
    Route::apiResource('/categories',CategoryController::class)->except('show');
});