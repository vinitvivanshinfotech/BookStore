<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\BookContoller;
use PhpParser\Node\Expr\Cast\Bool_;

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

Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login'); //return login view

Route::post('/login', [UserAuthController::class, 'userLoginPost'])->name('user.login'); //Authenticate user

Route::get('/register', [UserAuthController::class, 'showRegisterForm'])->name('register'); //return register  view

Route::post('/register', [UserAuthController::class, 'userRegistrationPost'])->name('user.register'); //register new user

Route::get('user/logout', [UserAuthController::class, 'userLogout'])->name('user.logout'); //logout user


Route::middleware(['auth'])->prefix('user')->group(function () {  // admin panel route

    Route::get('dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

    Route::get('dashboard/allBooks', [UserController::class, 'displayAllBooks'])->name('user.showBooks');
});

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.loginForm'); //admin login view

Route::post('/admin/loginPost', [AdminAuthController::class, 'adminLoginPost'])->name('admin.login'); // admin authentication

Route::get('/admin/logoutPost', [AdminAuthController::class, 'adminLogout'])->name('admin.logout'); // admin Logout



Route::middleware(['admin'])->prefix('admin')->group(function () {  // admin panel route

    Route::view('/admindashboard', 'Admin.dashboard')->name('admin.dashboard'); // route to show dashboard of admin.

    Route::view('/addbook', 'Admin.add_book')->name('add.books'); // route that show add book form  .

    Route::post('/save-book', [BookContoller::class, 'bookAdd'])->name('save.books'); // route to save book.

    Route::get('/showallbooks', [BookContoller::class, 'showAllBookBook'])->name('showAll.books'); // route of show edit book form.

    Route::get('/bookedit/{id}', [BookContoller::class, 'bookEditShow'])->name('edit.book'); // route that edit book .

    Route::post('/bookUpdate', [BookContoller::class, 'bookUpdate'])->name('update.book'); // route to update the book.

    Route::get('/deletebook/{id}', [BookContoller::class, 'bookDelete'])->name('delete.book'); // route to delete the book.

    Route::view('/allorderdisplay','Admin.order_book')->name('orders.display');//route for display all orders in table

    Route::get('/orderbook',[BookContoller::class,'orderBook'])->name('order.book');// display all books for order

    // Route::get('/orderdetails', [OrderDetailsController::class, 'orderDetails'])->name('order.details');// get
    Route::get( '/orderdetails/{id}', [BookContoller::class,'orderDetails'])->name('orderdetails.book');// return

    
});
