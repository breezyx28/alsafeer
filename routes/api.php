<?php

use App\Http\Controllers\BuyControllerResource;
use App\Http\Controllers\ExpensesControllerResource;
use App\Http\Controllers\ImportFromControllerResource;
use App\Http\Controllers\IndebtednessControllerResource;
use App\Http\Controllers\InvoiceControllerResource;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NewMeasureControllerResource;
use App\Http\Controllers\ReadySaleControllerResource;
use App\Http\Controllers\ReceiptControllerResource;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserControllerResource;
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

        // resources
        Route::apiResource('readySales', ReadySaleControllerResource::class)->only('store');
        Route::apiResource('buys', BuyControllerResource::class)->only('store');
        Route::apiResource('expenses', ExpensesControllerResource::class)->only('store');
        Route::apiResource('importFroms', ImportFromControllerResource::class)->only('store');
        Route::apiResource('Indebtednesses', IndebtednessControllerResource::class)->only('store');
        Route::apiResource('newMeasures', NewMeasureControllerResource::class)->only('store');
        Route::apiResource('receipts', ReceiptControllerResource::class)->only('store');
        Route::apiResource('invoices', InvoiceControllerResource::class)->only('show', 'index');
    });

    // admin
    Route::group(['prefix' => ADMIN, 'middleware' => 'adminWare'], function () {

        // resources
        Route::apiResources([
            'Users' => UserControllerResource::class,
            'readySales' => ReadySaleControllerResource::class,
            'buys' => BuyControllerResource::class,
            'expenses' => ExpensesControllerResource::class,
            'importFroms' => ImportFromControllerResource::class,
            'Indebtednesses' => IndebtednessControllerResource::class,
            'newMeasures' => NewMeasureControllerResource::class,
            'receipts' => ReceiptControllerResource::class,
            'invoices' => InvoiceControllerResource::class,
        ]);
    });
});
