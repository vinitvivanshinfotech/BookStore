<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// controller
use App\Http\Controllers\User\UserApiController;
use App\Http\Controllers\BookContoller;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(UserApiController::class)->group(function () {
    Route::get('/addToWishlist/{user_id}/{book_id}','addToWishlist');
    Route::get('/addToCart/{user_id}/{book_id}','addToCart');
    Route::get('getWatchlistCartData','getWatchlistCartData');
    Route::post('addRatings','addRatings');
});




