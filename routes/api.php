<?php

use App\Http\Controllers\BuyControllerResource;
use App\Http\Controllers\ExpensesControllerResource;
use App\Http\Controllers\ImportFromControllerResource;
use App\Http\Controllers\IndebtednessControllerResource;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceControllerResource;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NewMeasureControllerResource;
use App\Http\Controllers\ReadySaleControllerResource;
use App\Http\Controllers\ReceiptControllerResource;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserControllerResource;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


const BASE = 'v1/user';
const ADMIN = 'v1/admin';
const PUB = 'v1/public';

Route::post(BASE . '/login', [LoginController::class, 'Login']);
Route::post(BASE . '/register', [RegisterController::class, 'register']);

// public
Route::apiResource(PUB . '/readySales', ReadySaleControllerResource::class)->only('index');
Route::apiResource(PUB . '/buys', BuyControllerResource::class)->only('index');
Route::apiResource(PUB . '/expenses', ExpensesControllerResource::class)->only('index');
Route::apiResource(PUB . '/importFroms', ImportFromControllerResource::class)->only('index');
Route::apiResource(PUB . '/indebtedness', IndebtednessControllerResource::class)->only('index');
Route::apiResource(PUB . '/newMeasures', NewMeasureControllerResource::class)->only('index');
Route::apiResource(PUB . '/receipts', ReceiptControllerResource::class)->only('index');
Route::apiResource(PUB . '/invoices', InvoiceControllerResource::class)->only('show', 'index');
Route::apiResource(PUB . '/users', UserControllerResource::class)->only('index');
Route::post(PUB . '/reportBetween', [ReportsController::class, 'ReportBetween']);
// public end

// search
Route::get(BASE . '/search', [SearchController::class, 'search']);

Route::group(['middleware' => 'auth.jwt'], function () {

    Route::group(['prefix' => BASE, 'middleware' => 'userWare'], function () {

        // user personal
        Route::get('profile', [LoginController::class, 'profile']);
        Route::post('logout', [LoginController::class, 'logout']);
        Route::put('resetPassword', [LoginController::class, 'resetPassword']);
        Route::put('updateProfile', [LoginController::class, 'updateProfile']);

        // resources
        Route::apiResource('readySales', ReadySaleControllerResource::class)->only('store', 'index');
        Route::apiResource('buys', BuyControllerResource::class)->only('store', 'index');
        Route::apiResource('expenses', ExpensesControllerResource::class)->only('store', 'index');
        Route::apiResource('importFroms', ImportFromControllerResource::class)->only('store', 'index');
        Route::apiResource('indebtedness', IndebtednessControllerResource::class)->only('store', 'index');
        Route::apiResource('newMeasures', NewMeasureControllerResource::class)->only('store', 'index');
        Route::apiResource('receipts', ReceiptControllerResource::class)->only('store', 'index');
        Route::apiResource('invoices', InvoiceControllerResource::class)->only('show', 'index');
        Route::apiResource('users', UserControllerResource::class)->only('index');
    });

    // admin
    Route::group(['prefix' => ADMIN, 'middleware' => 'adminWare'], function () {

        // resources
        Route::apiResources([
            'users' => UserControllerResource::class,
            'readySales' => ReadySaleControllerResource::class,
            'buys' => BuyControllerResource::class,
            'expenses' => ExpensesControllerResource::class,
            'importFroms' => ImportFromControllerResource::class,
            'indebtednesses' => IndebtednessControllerResource::class,
            'newMeasures' => NewMeasureControllerResource::class,
            'receipts' => ReceiptControllerResource::class,
            'invoices' => InvoiceControllerResource::class,
        ]);

        Route::get('invoice/{invoiceNumber}', [InvoiceController::class, 'getInvoice']);
    });
});
