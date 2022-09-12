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

Route::resource('buyer', 'App\Http\Controllers\Buyer\BuyerController');
Route::resource('buyer.transaction', 'App\Http\Controllers\Buyer\BuyerTransactionController');
Route::resource('buyer.product', 'App\Http\Controllers\Buyer\BuyerProductController');
Route::resource('buyer.seller', 'App\Http\Controllers\Buyer\BuyerSellerController');
Route::resource('buyer.category', 'App\Http\Controllers\Buyer\BuyerCategoryController');

Route::resource('category', 'App\Http\Controllers\Category\CategoryController');
Route::resource('category.buyer', 'App\Http\Controllers\Category\CategoryBuyerController');
Route::resource('category.product', 'App\Http\Controllers\Category\CategoryProductController');
Route::resource('category.seller', 'App\Http\Controllers\Category\CategorySellerController');
Route::resource('category.transaction', 'App\Http\Controllers\Category\CategoryTransactionController');

Route::resource('product', 'App\Http\Controllers\Product\ProductController');

Route::resource('seller', 'App\Http\Controllers\Seller\SellerController', ['only' => ['index' => 'show']]);

Route::resource('transaction', 'App\Http\Controllers\Transaction\TransactionController');
Route::resource('transaction.category', 'App\Http\Controllers\Transaction\TransactionCategoryController');
Route::resource('transaction.seller', 'App\Http\Controllers\Transaction\TransactionSellerController');

Route::resource('user', 'App\Http\Controllers\User\UserController', ['except' => 'create', 'edit']);
