<?php

namespace App\Http\Controllers\Admin;

use App\Models\BookDetail;
use App\Http\Controllers\Controller;
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
// use BookDetailsRepositoryInterface;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Unique;
use DB;
use App\Services\UrlService;

class OrderDetailsController extends Controller
{
    /**
     * Desciption : Order book view page loading 
     *
     * @param :
     * @return : 
     */

     public function orderBookview()
     {
         try {
             Log::info('Order book view page loaded.');
             return view('Admin.order_book');
         } catch (Exception $e) {
             Log::error('Failed to load the order book.' . $e->getMessage());
             return response()->json(['error' => 'failed to load the order book '], '500');
         }
     }
 
     /**
      * Desciption : Showing all order list to admin panel latest by timestamp.
      *
      * @param :
      * @return : 
      */
     public function orderBook(Request $request)
     {
         try {
             // dd($request->all());
             // $orders = OrderDetail::orderBy('created_at', 'desc')->with(['user', 'book'])->where('order_status', '!=', 'Cancelled Order')->get();
 
             $columns = array(
                 0 => 'id',
                 1 => 'customer_name',
                 2 => 'orderid',
                 3 => 'book_total_price',
                 4 => 'book_total_quantity',
                 5 => 'order_status',
                 6 => 'options'
             );
             $totalData = BookDetail::count();
             $totalFiltered = $totalData;
             $limit = $request->input('length');
             $start = $request->input('start');
             $order = $columns[$request->input('order.0.column')];
             $dir = $request->input('order.0.dir');
 
             if (empty($request->input('search.value'))) {
                 $bookDetails = OrderDetail::offset($start)
                     ->where('order_status', '!=', 'Cancelled Order')
                     ->limit($limit)
                     ->get();
             } else {
                 $search = $request->input('search.value');
 
                 $bookDetails = BookDetail::where('id', 'LIKE', "%{$search}%")
                     ->orWhere('first_name', 'LIKE', "%{$search}%")
                     ->orWhere('last_name', 'LIKE', " %{$search}%")
                     ->orWhere('book_total_price', 'LIKE', "%{$search}%")
                     ->orWhere('book_total_quantity', 'LIKE', "%{$search}%")
                     ->orWhere('order_status', 'LIKE', "%{$search}%")
                     ->offset($start)
                     ->limit($limit)
                     ->get();
 
                 $totalFiltered = BookDetail::where('id', 'LIKE', "%{$search}%")
                     ->orWhere('first_name', 'LIKE', "%{$search}%")
                     ->orWhere('last_name', 'LIKE', " %{$search}%")
                     ->orWhere('book_total_price', 'LIKE', "%{$search}%")
                     ->orWhere('book_total_quantity', 'LIKE', "%{$search}%")
                     ->orWhere('order_status', 'LIKE', "%{$search}%")
                     ->count();
             }
             $data = array();
             if (count($bookDetails) > 0) {
 
                 foreach ($bookDetails as $detail) {
                     $info = route('orderdetails.book', $detail->id);
                     $delete = route('delete.order', $detail->id);
 
                     $nestdata['id'] = $detail->id;
                     $nestdata['customer_name'] = $detail['user']['first_name'];
                     $nestdata['orderid'] = $detail['id'];
                     $nestdata['book_total_price'] = $detail['book_total_price'];
                     $nestdata['book_total_quantity'] = $detail['book_total_quantity'];
                     $nestdata['order_status'] = $detail['order_status'];
                     $nestdata['options'] = "&emsp;<a href='{$info}' title='show'></a>
                                             &emsp;<a href='{$delete}' title='show'></a>";
 
                     $data[] = $nestdata;
                 }
 
                 $json_data = array(
                     "draw"            => intval($request->input('draw')),
                     "recordsTotal"    => intval($totalData),
                     "recordsFiltered" => intval($totalFiltered),
                     "data"            => $data
                 );
 
                 Log::info('Fetching the all order  from the database : ');
 
                 echo json_encode($json_data);
             }
         } catch (Exception $e) {
             Log::error('Attempt to fetching  the order details' . $e->getMessage());
             return response()->json(['message' => "Error in order details this book"], 500);
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
             \Log::info('this is id  ' . $id);
             $orderDetails = ShippingDetail::join('order_details', 'order_details.id', '=', 'shipping_details.order_id')
                 ->join('payment_books', 'payment_books.id', '=', 'order_details.payment_id')
                 ->join('order_descripitions', 'order_descripitions.order_id', '=', 'order_details.id')
                 ->join('book_details', 'book_details.id', '=', 'order_descripitions.book_id')->where('shipping_details.order_id', $id)
                 ->get();
 
             Log::info('Fetching the all order details from the database : ');
 
             $data = view('Admin.order_details', compact('orderDetails'))->render();
 
             return response()->json([
                 'status' => true,
                 'data' => $data,
                 'success' => 'Order Details are successfully shown.',
             ]);
         } catch (\Exception $e) {
             Log::error('Attempt to fetching all order details is failed try again , Error: ' . $e->getMessage());
             return response()->json(['error' => "Error in fetching the order details "], 500);
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
             DB::beginTransaction();
             $id = $request->id;
             $order = OrderDetail::findOrFail($id);
 
             if ($order['order_status'] != "Cancelled Order") {
 
                 $order->order_status = 'Cancelled Order';
                 $order->save();
 
                 Log::info('Deleted order with ID: ' . $id);
                 return response()->json(['success' => 'Order Deleted successfully.'], 200);
                 // return redirect()->route('order.book')->with('success', 'Order deleted successfully.');
             } else {
                 Log::error('Attempt to delete order with ID ' . $id . ' failed. Reason: Record not found.');
                 DB::commit();
                 return response()->json(['error' => 'Order not found.'], 404);
             }
         } catch (\Exception $e) {
             Log::error('Attempt to delete order with ID ' . $id . ' failed. Error: ' . $e->getMessage());
             DB::commit();
             return response()->json(['error' => 'An error occurred while deleting the order.'], 500);
         }
     }
}
