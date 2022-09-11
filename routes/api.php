<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('buyer', 'App\Http\Controllers\Buyer\BuyerController', ['only' => ['index' => 'show']]);
Route::resource('category', 'App\Http\Controllers\Category\CategoryController', ['except' => 'create', 'edit']);
Route::resource('product', 'App\Http\Controllers\Product\ProductController', ['only' => ['index' => 'show']]);
Route::resource('seller', 'App\Http\Controllers\Seller\SellerController', ['only' => ['index' => 'show']]);
Route::resource('transaction', 'App\Http\Controllers\Transaction\TransactionController', ['only' => ['index' => 'show']]);
Route::resource('user', 'App\Http\Controllers\User\UserController', ['except' => 'create', 'edit']);
