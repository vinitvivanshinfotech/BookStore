<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Import Models
use App\Models\BookDetail;

class UserController extends Controller
{
    /**
     * Desciption return user dashboard: 
     * 
     * @param
     * @return : user dashboard view
     */ 
    public function dashboard()
    {
        return view('User.dashboard');
    }


    /**
     * Desciption : retun all books page to the user 
     * 
     * @param
     * @return \view all books
     */
    public function displayAllBooks()
    {

        $books = BookDetail::simplePaginate(6);
        // Return the View with Data
        return view("User.all_books")->with(compact('books'));
    }

}
