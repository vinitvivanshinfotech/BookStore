<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('welcome');
});




Route::view('/admindashboard', 'Admin.dashboard')->name('admin.dashboard'); // route to show dashboard of admin.

Route::view('/addbook', 'Admin.add_book')->name('add.books'); // route that show add book form  .

Route::post('/save-book', [BookContoller::class, 'bookAdd'])->name('save.books'); // route to save book.

Route::get('/showallbooks', [BookContoller::class, 'showAllBookBook'])->name('showAll.books'); // route of show edit book form.

Route::get('/bookedit/{id}', [BookContoller::class, 'bookEditShow'])->name('edit.book'); // route that edit book .

Route::post('/bookUpdate', [BookContoller::class, 'bookUpdate'])->name('update.book'); // route to update the book.

Route::get('/deletebook/{id}', [BookContoller::class, 'bookDelete'])->name('delete.book'); // route to delete the book.