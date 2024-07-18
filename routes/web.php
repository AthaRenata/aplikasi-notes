<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\LoginController;

Route::controller(LoginController::class)
->group(function () {
    Route::get("/","index")->name('login')->middleware('guest');
    Route::post("/","authenticate");
    Route::post("/logout","logout");
});

Route::middleware('auth')->group(function () {
    Route::resource('/users', UserController::class)->except(['show']);
    Route::get('/users/activate', [UserController::class,'inactiveList']);
    Route::patch('/users/activate/{user}', [UserController::class,'activateUser']);
});