<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserOrderController;
use App\Http\Controllers\BookContoller;

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



//GUEST ROTES
Route::middleware(['guest:user'])->controller(UserAuthController::class)->group(function () {
    Route::get('/', 'showLoginForm')->name('login');
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'userLoginPost')->name('user.login');
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'userRegistrationPost')->name('user.register');
});





Route::middleware(['auth:user'])->group(function () {

    Route::get('user/logout', [UserAuthController::class, 'userLogout'])->name('user.logout');

    //USER AUTHENTICATED ROUTES
    Route::controller(UserController::class)->prefix('dashboard')->name('user.')->group(function () {
        Route::get('/',  'dashboard')->name('dashboard');
        Route::get('allBooks',  'displayAllBooks')->name('showBooks');
        Route::get('allBooks/bookDetails',  'bookDetails')->name('bookDetails');
        Route::get('myWatchlist',  'myWatchlist')->name('watchlist');
        Route::post('myWatchlist/removebook', 'removeFromWatchlist')->name('removeFromWatchlist');
        Route::post('myWatchlist/removebookFromcart', 'removeFromCart')->name('removeFromCart');
        Route::get('myCart',  'myCart')->name('cart');
        Route::post('quantityChange', 'quantityChange')->name('quantityChange');
    });

    Route::controller(UserOrderController::class)->prefix('order')->name('user.')->group(function () {
        Route::post('placeorder', 'makeAnOrder')->name('placeOrder');
        Route::get('addShippingDetails', 'ShippingDetailsForm')->name('ShippingDetailsForm');
        Route::get('myOrders', 'viewMyOrders')->name('myOrders');
        Route::post('orderMoreInfo', 'orderMoreInfo')->name('orderMoreInfo');
        Route::post('addBookReview', 'addBookReview')->name('addBookReview');
    });
});


Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

    Route::get('/logoutPost', [AdminAuthController::class, 'adminLogout'])->name('admin.logout');

    // view route
    Route::view('/dashboard', 'Admin.dashboard')->name('admin.dashboard');
    Route::view('/addbook', 'Admin.add_book')->name('add.books');
    Route::view('/allorderdisplay', 'Admin.order_book')->name('orders.display');


    //Bookcontroller
    Route::prefix('book')->controller(BookContoller::class)->group(function () {
        Route::post('/save',  'bookAdd')->name('save.books');
        Route::get('/allbooks',  'showAllBookBook')->name('showAll.books');
        Route::get('/edit/{id}',  'bookEditShow')->name('edit.book');
        Route::post('/bookUpdate',  'bookUpdate')->name('update.book');
        Route::get('/delete/{id}',  'bookDelete')->name('delete.book');
        Route::get('/order', 'orderBook')->name('order.book');
        Route::post('/updateorderstatus', 'updateOrderStatus')->name('update.order.status');
        Route::get('/orderdetails/{id}', 'orderDetails')->name('orderdetails.book');
        Route::Post('/rejectingorder/{id}', 'deleteOrder')->name('delete.order');

        Route::get('/sendingcsvtoadmin', 'sendorderlist')->name('sendingordercsvfile');
    });
});
