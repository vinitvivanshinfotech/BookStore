<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\BookDetail;



class CategoryController extends Controller
{
    /**
     * Desciption : Loading the view  for creating a book category.
     *
     * @param :
     * @return : 
     */
    public function categories(Request $request)
    {
        try {
            Log::error('book categories view page load successfully');
            return view('Admin.categories');
        } catch (\Exception $e) {
            Log::error('Attempt to load the view page of book category ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while loading the book category.'], 500);
        }
    }

    /**
     * Desciption : Find the book which is avaliable in our store from the given category 
     *
     * @param $request
     * @return : $book_types 
     */

    public  function categoryBookView(Request $request)
    {
        try {
            $book_types = BookDetail::where('book_type', $request->categories)->get();

            return response()->json($book_types);
            // return view('Admin.categories', ["book_types", $book_types]);
        } catch (\Exception $e) {
            Log::error('Attempt to Read the book category ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while see book category.'], 500);
        }
    }
}
