<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [App\Http\Controllers\IndexController::class, 'index']);

Route::prefix('product')->group(function() {
    Route::get('/', [ProductController::class, 'index'])->middleware('auth');

    Route::get('/search', [ProductController::class, 'search']);
    Route::post('/search', [ProductController::class, 'search']);
    
    Route::get('/edit/{id?}', [ProductController::class, 'edit'])->middleware('auth');
    Route::post('/add', [ProductController::class, 'insert'])->middleware('auth');
    Route::post('/update', [ProductController::class, 'update'])->middleware('auth');
    Route::get('/remove/{id}', [ProductController::class, 'remove'])->middleware('auth');
});

Route::get('/category', [CategoryController::class, 'index'])->middleware('auth');

Route::prefix('cart')->group(function() {
    Route::get('/view', [CartController::class, 'viewCart']);
    Route::get('/add/{id}', [CartController::class, 'addToCart']);
    Route::get('/update/{id}/{qty}', [CartController::class, 'updateCart']);
    Route::get('/delete/{id}', [CartController::class, 'deleteCart']);
});
