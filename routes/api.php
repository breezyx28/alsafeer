<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SearchController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


const BASE = 'v1/user';
const ADMIN = 'v1/admin';

Route::post(BASE . '/login', [LoginController::class, 'Login']);
Route::post(BASE . '/register', [RegisterController::class, 'register']);

Route::group(['middleware' => 'auth.jwt'], function () {

    Route::group(['prefix' => BASE, 'middleware' => 'userWare'], function () {

        // user personal
        Route::get('profile', [LoginController::class, 'profile']);
        Route::post('logout', [LoginController::class, 'logout']);
        Route::put('resetPassword', [LoginController::class, 'resetPassword']);
        Route::put('updateProfile', [LoginController::class, 'updateProfile']);

        // search
        Route::get('search', [SearchController::class, 'SearchController']);
    });

    // admin
    Route::group(['prefix' => ADMIN, 'middleware' => 'adminWare'], function () {
    });
});
