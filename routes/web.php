<?php

use Illuminate\Support\Facades\Route;

// controller
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login',[UserAuthController::class,'showLoginForm'])->name( 'login' );
Route::post('/login',[UserAuthController::class,'userLoginPost'])->name('user.login');
Route::get('/register',[UserAuthController::class,'showRegisterForm'])->name( 'register' );
Route::post('/register',[UserAuthController::class,'userRegistrationPost'])->name( 'user.register' );

Route::middleware(['auth'])->prefix( 'user' )->group(function(){  // admin panel route
    Route::get('dashboard', [ UserController::class, 'dashboard' ] )->name( 'user.dashboard') ;
});

Route::get('/admin/login',[AdminAuthController::class,'showLoginForm'])->name('admin.loginForm');
Route::post('/admin/loginPost',[AdminAuthController::class,'adminLoginPost'])->name('admin.login');

Route::middleware(['admin'])->prefix( 'admin' )->group(function(){  // admin panel route
    Route::get('dashboard', [ UserController::class, 'dashboard' ] )->name( 'admin.dashboard') ;
});

// Route::get('/login',[])


