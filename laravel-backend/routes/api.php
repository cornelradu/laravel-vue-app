<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider and all of them will
    | be assigned to the "api" middleware group. Make something great!
    |
    */
Route::group([

        'middleware' => 'api',
        'prefix' => 'auth'
    
    ], function ($router) {
        Route::post('/login', [LoginController::class, 'login']);
        
        
    
    });
    
Route::post('/orders', [OrderController::class, 'order']);
Route::get('/orders', [OrderController::class, 'get']);
Route::post('/me', [LoginController::class, 'me']);

Route::withoutMiddleware('api')->group(function () {
    Route::get('/products/{id}', [ProductController::class, 'getProductById']);

    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);


    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);


    Route::get('/sub_categories', [SubcategoryController::class, 'index']);
    Route::post('/sub_categories', [SubcategoryController::class, 'store']);
});



?>