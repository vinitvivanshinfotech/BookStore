<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// controller
use App\Http\Controllers\User\UserApiController;

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

Route::get('/addToWishlist/{user_id}/{book_id}',[UserApiController::class,'addToWishlist']);
Route::get('/addToCart/{user_id}/{book_id}',[UserApiController::class,'addToCart']);