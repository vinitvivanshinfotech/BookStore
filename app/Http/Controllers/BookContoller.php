<?php

namespace App\Http\Controllers;

use App\Models\BookDetail;
use Illuminate\Http\Request;
use App\Http\Requests\saveBookRequest;
use App\Http\Requests\updateBookRequest;


class BookContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function bookAdd(saveBookRequest $request)
    {
        // Storing the Book_cover in local storage 

        $file = $request->book_cover;
        $filename = $file->getClientOriginalName();
        $file->storeAs('public/', $filename);


        // Adding the new books in database 
        $book = BookDetail::create([
            'book_name' => $request->book_name,
            'book_title' => $request->book_title,
            'author_name' => $request->author_name,
            'author_email' => $request->author_email,
            'book_edition' => $request->book_edition,
            'description' => $request->description,
            'book_cover' => $request->book_cover->getClientOriginalName(),
            'book_price' => $request->book_price,
            'book_language' => $request->book_language,
            'book_type' => $request->book_type,
        ]);

        // return to showing all books page  with success message.
        return redirect()->route('showAll.books')->with("success", 'Book added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function showAllBookBook()
    {
        // finding all the books from table.
        $all_books = BookDetail::all();

        // return to showing all books page with all book data.
        return view('Admin.show_all_book', ['all_books' => $all_books]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function bookEditShow(string $id)
    {
        // finding the book with id.
        $edit_book = BookDetail::findOrFail($id);

        // finding the book_edition , book_language,book_type.
        $book_edition = explode(',', $edit_book['book_edition']);

        $book_language = explode(',', $edit_book['book_language']);

        $book_type = explode(',', $edit_book['book_type']);

        // return to showing the edit page with book data.
        return view("Admin.edit_book", ["book" => $edit_book, 'book_edition' => $book_edition, 'book_language' => $book_language, 'book_type' => $book_type]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function bookUpdate(updateBookRequest $request)
    {
        // finding the  book with request->id and storing it in a variable and update all the data.
        $book =  BookDetail::find($request->id);
        $book->update($request->all());

        // return to showing all books page with succes  message .
        return redirect()->route('showAll.books')->with("success", 'Book Updated Successfully ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function bookDelete(string $id)
    {
        // finding  the book with id and delete it.
        $book = BookDetail::findOrFail($id);

        $book->delete();

        // return to showing all books page with success message .
        return  redirect()->route("showAll.books")->with("success", "succesfully delete the book");
    }
}
