<?php

namespace App\Http\Controllers;

use App\Models\BookDetail;
use Illuminate\Http\Request;
use App\Http\Requests\saveBookRequest;
use App\Http\Requests\updateBookRequest;
use App\Jobs\SendOrderListToAdmin;
use App\Mail\SendInvoiceToUser;
use App\Models\OrderDetail;
use App\Models\PaymentBook;
use App\Models\ShippingDetail;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Symfony\Component\VarDumper\VarDumper;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Unique;

// use App\Traits\InvoiceDetailsTrait;

class BookContoller extends Controller
{

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

        $data = $request->except('book_cover', '_token');
        $data['book_cover'] = $file_path;
        BookDetail::create($data);

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
        try {
            $books = BookDetail::all();

            Log::info('Getting all books from dabase by admin ');
            return view('Admin.show_all_book', compact('books'));
        } catch (\Exception $e) {
            Log::error('Error while fetching all book : ' . ': ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Desciption : This function fetch the one book from the dataabse
     * and  show them on the edit book page.
     * @param : id
     * @return : book,book_edition,book_language,book_type
     */
    public function bookEditShow(string $id)
    {
        try {

            $book = BookDetail::findOrFail($id);

            $bookEdition = explode(',', $book['book_edition']);
            $bookLanguage = explode(',', $book['book_language']);
            $bookType = explode(',', $book['book_type']);

            Log::info('Updateing the book details  with id: ' . $id . '.');
            return view("Admin.edit_book", ["book" => $book, 'bookEdition' => $bookEdition, 'bookLanguage' => $bookLanguage, 'bookType' => $bookType]);
        } catch (\Exception $e) {
            Log::error('Error in while showing book details with id : ' . $id . ': ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Desciption : This function update the book in the database.
     *
     * @param : request
     * @return : 
     */
    public function bookUpdate(updateBookRequest $request)
    {
        try {

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

            $data = $request->except('book_cover');
            $data['book_cover'] = $book->book_cover;
            $book->update($data);

            Log::info('Updateing the book details  with id: ' . $request->id . '.');
            return redirect()->route('showAll.books')->with("success", 'Book Updated Successfully ');
        } catch (\Exception $e) {
            Log::error('Error in updating book details with id : ' . $request->id . ': ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Desciption : This function is used for deleting a specific book from database by its id .
     *
     * @param :id
     * @return : 
     */
    public function bookDelete(string $id)
    {
        try {
            $book = BookDetail::findOrFail($id);

            if (Storage::disk(config('constant.FILESYSTEM_DISK'))->exists($book->book_cover)) {
                Storage::disk(config('constant.FILESYSTEM_DISK'))->delete($book->book_cover);
            }
            $book->delete();
            Log::info('delete the book with id: ' . $id . '.');
            return  redirect()->route("showAll.books")->with("success", "succesfully delete the book");
        } catch (\Exception $e) {
            Log::error('Attempt to deleteing  the book with id ' . $id . 'fails  , Error: ' . $e->getMessage());
            return response()->json(['message' => "Error in deleting this book"], 500);
        }
    }


    /**
     * Desciption : Showing all order list to admin panel latest by timestamp.
     *
     * @param :
     * @return : 
     */
    public function orderBook()
    {
        try {

            $orders = OrderDetail::orderBy('created_at', 'desc')->with(['user', 'book'])->where('order_status', '!=', 'Cancelled Order')->get();
            $order_status =  $orders[0]['order_status'];
            $order_status = explode(',', $orders[0]->order_status);

            Log::info('Fetching the all order  from the database : ');
            return view('Admin.order_book', ['orders' => $orders, 'order_status' => $order_status]);
        } catch (\Exception $e) {
            Log::error('Attempt to fetching all order is fails  , Error: ' . $e->getMessage());
            return response()->json(['message' => "Error in fetching the order "], 500);
        }
    }

    // use InvoiceDetailsTrait;
    /**
     * Desciption : Showing the all order details  of a specific user.
     *
     * @param :id
     * @return : 
     */
    public function orderDetails($id)
    {
        try {
            $orderDetails = ShippingDetail::join('order_details', 'order_details.id', '=', 'shipping_details.order_id')
                ->join('payment_books', 'payment_books.id', '=', 'order_details.payment_id')
                ->join('order_descripitions', 'order_descripitions.order_id', '=', 'order_details.id')
                ->join('book_details', 'book_details.id', '=', 'order_descripitions.book_id')->where('shipping_details.order_id', $id)
                ->get();

            Log::info('Fetching the all order details from the database : ');
            return view('Admin.order_details', compact('orderDetails'));
        } catch (\Exception $e) {
            Log::error('Attempt to fetching all order details is failed try again , Error: ' . $e->getMessage());
            return response()->json(['message' => "Error in fetching the order details "], 500);
        }
    }

    /**
     * Desciption : Updateing the order status from admin panel .
     *
     * @param :request
     * @return : 
     */
    public function updateOrderStatus(Request $request)
    {
        try {
            $order = OrderDetail::find($request->id);
            $order->update(['order_status' => $request->order_status]);
            if ($request->order_status == "Shipped Order") {
                $this->sendInvoiceToUser($request->id);
            }
            Log::info('Updated order with ID ' . $request->id . ' to status ' . $request->order_status . '.');
            return response()->json(['success' => 'Order status updated successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Error updating order with ID ' . $request->id . ': ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Desciption : Rejecting/deleting the order from admin side.php artisan vendor:publish --provider='Fedeisas\LaravelMailCssInliner\LaravelMailCssInlinerServiceProvider'
     *
     * @param :id 
     * @return : 
     */
    public function deleteOrder(Request $request)
    {

        try {
            $id = $request->id;
            $order = OrderDetail::findOrFail($id);

            if ($order['order_status'] != "Cancelled Order") {

                $order->order_status = 'Cancelled Order';
                $order->save();

                Log::info('Deleted order with ID: ' . $id);
                return redirect()->route('order.book')->with('success', 'Order deleted successfully.');
            } else {
                Log::error('Attempt to delete order with ID ' . $id . ' failed. Reason: Record not found.');
                return response()->json(['error' => 'Order not found.'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Attempt to delete order with ID ' . $id . ' failed. Error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while deleting the order.'], 500);
        }
    }

    /**
     * Desciption : This function which sending invoice in mail to user when the order is shiped.
     *
     * @param :id
     * @return : 
     */
    public function sendInvoiceToUser($id)
    {
        try {

            $orderDetails = ShippingDetail::join('order_details', 'order_details.id', '=', 'shipping_details.order_id')
                ->join('payment_books', 'payment_books.id', '=', 'order_details.payment_id')
                ->join('order_descripitions', 'order_descripitions.order_id', '=', 'order_details.id')
                ->join('book_details', 'book_details.id', '=', 'order_descripitions.book_id')->where('shipping_details.order_id', $id)
                ->get();
            $email = $orderDetails[0]['email'];
            $customer_name = $orderDetails[0]['first_name'] . '' . $orderDetails[0]['last_name'];
            $html = (string)View::make('Admin.order_details', compact('orderDetails'));
            $pdf = PDF::loadHTML($html);

            $tempFilePath = tempnam(sys_get_temp_dir(), 'pdf_');
            file_put_contents($tempFilePath, $pdf->output());

            Mail::to($email)->send(new SendInvoiceToUser(['path' => $tempFilePath], ['customer_name' => $customer_name]));

            Log::info('Sending the invoice to user when order is shipped the order id : ' . $id);
            return  back()->with('success', 'The invoice has been sent to your email! Please check it out');
        } catch (\Exception $e) {
            Log::error('Attempt to send invoice to user with order ID ' . $id . ' failed. Error: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while deleting the order.'], 500);
        }
    }

    /**
     * Desciption : 
     *
     * @param :
     * @return : 
     */
    public function categories(Request $request)
    {
        try {
            return view('Admin.categories');
        } catch (\Exception $e) {
        }
    }

    /**
     * Desciption : 
     *
     * @param :
     * @return : 
     */

    public  function categoryBookView(Request $request)
    {
        try {

            $book_types = BookDetail::where('book_type', $request->categories)->get();
            return view('Admin.categories', ["book_types", $book_types]);
        } catch (\Exception $e) {
            Log::error('Attempt to Read the list of book type ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while fet the order.'], 500);
        }
    }
}
