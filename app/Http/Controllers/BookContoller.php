<?php

namespace App\Http\Controllers;

use App\Models\BookDetail;
use Illuminate\Http\Request;
use App\Http\Requests\saveBookRequest;
use App\Http\Requests\updateBookRequest;
use App\Models\OrderDetail;
use App\Models\ShippingDetail;
use App\Models\ShippingDetails;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;




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
     * Desciption : This function which used to save the book in database.
     *
     * @param :request
     * @return :
     */
    public function bookAdd(saveBookRequest $request)
    {
        // Storing the Book_cover in local storage 
        $file_name = uniqid() . '_' . time() . '.' . $request->book_cover->getClientOriginalExtension();

        $file_path = "uploads/books_covers/$file_name";

        Storage::disk(config('constant.FILESYSTEM_DISK'))->put($file_path, file_get_contents($request->book_cover));

        // Adding the new books in database 
        $book = BookDetail::create([
            'book_name' => $request->book_name,
            'book_title' => $request->book_title,
            'author_name' => $request->author_name,
            'author_email' => $request->author_email,
            'book_edition' => $request->book_edition,
            'description' => $request->description,
            'book_cover' => $file_path,
            'book_price' => $request->book_price,
            'book_language' => $request->book_language,
            'book_type' => $request->book_type,
        ]);

        // return to showing all books page  with success message.
        return redirect()->route('showAll.books')->with("success", 'Book added successfully!');
    }


    /**
     * Desciption : This function fetch all bookes from the dataabse
     * and  show them on the show all book page.
     * @param :
     * @return : all_books
     */
    public function showAllBookBook()
    {
        // finding all the books from table.
        $all_books = BookDetail::all();

        // return to showing all books page with all book data.
        return view('Admin.show_all_book', ['all_books' => $all_books]);
    }

    /**
     * Desciption : This function fetch the one book from the dataabse
     * and  show them on the edit book page.
     * @param : id
     * @return : book,book_edition,book_language,book_type
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
     * Desciption : This function update the book in the database.
     *
     * @param : request
     * @return : 
     */
    public function bookUpdate(updateBookRequest $request)
    {

        $book =  BookDetail::find($request->id);

        // Storing the Book_cover in local storage 
        if ($request->book_cover != null) {

            if (Storage::disk(config('constant.FILESYSTEM_DISK'))->exists($book->book_cover)) {
                Storage::disk(config('constant.FILESYSTEM_DISK'))->delete($book->book_cover);
            }

            // Storing the Book cover in local storage 
            $file_name = uniqid() . '_' . time() . '.' . $request->book_cover->getClientOriginalExtension();

            $file_path = "uploads/books_covers/$file_name";
            Storage::disk(config('constant.FILESYSTEM_DISK'))->put($file_path, file_get_contents($request->book_cover));
            $book->book_cover = $file_path;
        }

        $book->update([
            'book_name' => $request->book_name,
            'book_title' => $request->book_title,
            'author_name' => $request->author_name,
            'author_email' => $request->author_email,
            'book_edition' => $request->book_edition,
            'description' => $request->description,
            'book_cover' => $book->book_cover,
            'book_price' => $request->book_price,
            'book_language' => $request->book_language,
            'book_type' => $request->book_type,
        ]);

        // return to showing all books page with succes  message .
        return redirect()->route('showAll.books')->with("success", 'Book Updated Successfully ');
    }

    /**
     * Desciption : This function is used for deleting a specific book from database by its id .
     *
     * @param :id
     * @return : 
     */
    public function bookDelete(string $id)
    {
        // finding the book with id and delete it.
        $book = BookDetail::findOrFail($id);
        try {

            // deleteing the book_cover from storage.
            if (Storage::disk(config('constant.FILESYSTEM_DISK'))->exists($book->book_cover)) {
                Storage::disk(config('constant.FILESYSTEM_DISK'))->delete($book->book_cover);
            }
            $book->delete();
            Log::info('delete the book with id: ' . $id . '.');
            // return to showing all books page with success message .
            return  redirect()->route("showAll.books")->with("success", "succesfully delete the book");
        } catch (\Exception $e) {
            Log::error('Attempt to deleteing  the book with id ' . $id . 'fails  , Error: ' . $e->getMessage());
            return response()->json(['message' => "Error in deleting this book"], 500);
        }
    }


    /**
     * Desciption : 
     *
     * @param :
     * @return : 
     */
    public function orderBook()
    {
        $orders = OrderDetail::orderBy('created_at', 'desc')->with(['user', 'book'])->get();

    
        $order_status =  $orders[1]['order_status'];
        $order_status= explode(',',$orders[1]->order_status );
        
        return view('Admin.order_book',['orders' => $orders,'order_status'=> $order_status]);
    }

    /**
     * Desciption : 
     *
     * @param :
     * @return : 
     */
    public function  orderDetails(string $id)
    {

        $orderdetasils = ShippingDetail::where('order_id', $id)->first();
        return view('Admin.order_details')->with('orderdetails', $orderdetasils);
    }

    /**
     * Desciption : 
     *
     * @param :
     * @return : 
     */
    public function updateOrderStatus(Request $request)
    {
        dd($request->toArray());
    }

    /**
     * Desciption : 
     *
     * @param :
     * @return : 
     */
    public function deleteOrder(int $id)
    {
        // dd($id);
        // finding the book with id and delete it.
        try {

            $order = OrderDetail::find($id);
            $cancelledOrder = "Cancelled Order";
            // dd($order);
            $order->update([
                'order_status' => $cancelledOrder,
            ]);
            Log::info('delete the order with id: ' . $id . '.');
            // return to showing all books page with success message .
            return  redirect()->route('order.book')->with("success", "succesfully delete the order.");
        } catch (\Exception $e) {
            Log::error('Attempt to deleteing  the book with id ' . $id . 'fails  , Error: ' . $e->getMessage());
            return response()->json(['message' => "Error in deleting this order"], 500);
        }
    }
}
