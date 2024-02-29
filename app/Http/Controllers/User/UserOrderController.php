<?php

namespace App\Http\Controllers\User;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ShippingDetailsRequest;
use App\Models\BookDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


// Model
use App\Models\User;
use App\Models\PaymentBook;
use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\OrderDescripition;
use App\Models\ShippingDetail;

// Jobs
use App\Jobs\OrderPlacedPdfSendJob;
use App\Mail\OrderPlacedPdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserOrderController extends Controller
{

    /**
     * Desciption : 
     * 
     * @param : 
     * @return : 
     */
    public function ShippingDetailsForm()
    {
        $user = Auth()->user();
        return view('User.add_shipping_details')->with('user', $user);
    }

    /**
     * Desciption : this function will download generated invoice
     * 
     * @param : PDF $pdf
     * @return : invoice pdf file download
     */ 
   


    /**
     * Desciption : 
     * 
     * @param : App\Http\Requests\ShippingDetailsRequest $request
     * @return : 
     */
    public function makeAnOrder(ShippingDetailsRequest $request)
    {
        $userId = Auth::user()->id;

        try {
            DB::beginTransaction();
            $cartitems = Cart::where('user_id', $userId)->get()->toArray();

            if ($cartitems == null || count($cartitems) == 0) {
                return redirect()->back()->with('failure', __('messages.empty_cart'));
            }

            $paymentId = PaymentBook::create([
                'user_id' => $userId,
                'payment_mode' => $request->input('payment_mode'),
            ])->id;

            if (empty($paymentId)) {
                Log::info('payment failed of user = ' . $userId . " ");
                return redirect()->back()->with('failure', __('messages.payment_fail'));
            }

            Log::info('user ' . $userId . " payment book id " . $paymentId . " created");

            //Join the book_details and carts table and will return total discount, total sum of cart items , total cart value=sum(book_price * book_quantity) 
            $cart = Cart::where('user_id', $userId)
                ->join('book_details', 'carts.book_id', '=', 'book_details.id')
                ->selectRaw('SUM(carts.book_quantity) as total_ordered_book_qty,
                 SUM(carts.book_quantity * book_details.book_discount) as total_ordered_book_discount,
                 SUM(carts.book_quantity * book_details.book_price) as total_ordered_book_price')
                ->first();

            $totalOrderedBookQty = $cart->total_ordered_book_qty;
            $totalOrderedBookDiscount = $cart->total_ordered_book_discount;
            $totalOrderedBookPrice = $cart->total_ordered_book_price;

            $orderDetails = OrderDetail::create([
                'user_id' => $userId,
                'book_total_price' => ($totalOrderedBookPrice - $totalOrderedBookDiscount),
                'book_total_quantity' =>  $totalOrderedBookQty,
                'book_shipdate' => Carbon::now()->addDays(2),
                'book_billdate' =>  Carbon::now(),
                'payment_id' => $paymentId,
                'order_status' => 'Placed Order'
            ]);

            if (empty($orderDetails)) {
                Log::info('orderdetails addintion failed of = ' . $userId . " ");
                return redirect()->back()->with('failure', __('messages.order_fail'));
            }

            Log::info('user ' . $userId . " order" . $orderDetails->id . " created");


            foreach ($cartitems as $item) {

                OrderDescripition::create([
                    'order_id' => $orderDetails->id,
                    'book_id' => $item['book_id'],
                    'book_quantity' => $item['book_quantity'],
                ]);
                Log::debug($item['book_quantity']);
            }

            $postData = $request->except('_token');

            $postData['order_id'] = $orderDetails->id;

            $shippingDetails = ShippingDetail::create($postData);

            if (empty($shippingDetails)) {
                Log::info('shippingDetails addintion failed of = ' . $userId . " ");
                return redirect()->back()->with('failure', __('messages.shipping_details_add_fail'));
            }

            Log::info('Order placed of Order id :' . $orderDetails->id);
            Cart::where('user_id', $userId)->delete();


            // SEND THE ORDER DETAILS TO THE ADMIN
            $orderId =  $orderDetails->id;
            $data = OrderDetail::join('order_descripitions', 'order_details.id', '=', 'order_descripitions.order_id')
                ->join('book_details', 'book_details.id', '=', 'order_descripitions.book_id')->join('shipping_details', 'shipping_details.order_id', '=', 'order_details.id')
                ->selectRaw('order_details.*,
                order_descripitions.book_quantity,
                book_details.book_name,
                book_details.book_title,
                book_details.author_name,
                book_details.book_edition,
                book_details.description,
                book_details.book_cover,
                book_details.book_price,
                book_details.book_language,
                book_details.book_type,
                book_details.book_discount,
                shipping_details.first_name,
                shipping_details.last_name,
                shipping_details.email,
                shipping_details.phone_number,
                shipping_details.address,
                shipping_details.pincode,
                shipping_details.city,
                shipping_details.state
                ')
                ->where('order_details.user_id', $userId)->where('order_details.id', $orderId)->distinct('order_descripitions.book_id')->get()->toArray();

            $pdf = PDF::loadView('User.userLayout.invoice_email', compact('data'));
            $invoiceName = "order-{$orderId}";

            $tempFilePath = tempnam(sys_get_temp_dir(), 'pdf_');
            file_put_contents($tempFilePath, $pdf->output());


            DB::commit();

            Mail::to(env('ORDER_PLACED_MAIL', 'keyur.s@vivanshinfotech.com'))
            ->send(new OrderPlacedPdf([
                'data' => $data,
                'filePath' => $tempFilePath,
                'invoiceName' => $invoiceName
            ]));


            return $pdf->download();

        } catch (\Exception $th) {
            DB::rollBack();
            Log::error(__METHOD__ . 'line' . __LINE__ . " Error in making an order" . $th->getMessage());
            Session::flash("failure", 'Something went wrong!');
        }
    }

    
    

    /**
     * Desciption : return  orders view  of Authenticated user
     * 
     * @param : 
     * @return : $orders
     */
    public function viewMyOrders()
    {
        $userId = Auth::User()->id;

        //get all orders from the
        $orders = OrderDetail::where('user_id', $userId)->with(['orderDescription'])->get()->toArray();
        return view('User.my_orders')->with(compact('orders'));
    }

    /**
     * Desciption : 
     * 
     * @param : 
     * @return : 
     */

    public function orderMoreInfo(Request $request)
    {

        $userId = Auth()->user()->id;
        $orderId = $request->order_id;
        $data = OrderDetail::join('order_descripitions', 'order_details.id', '=', 'order_descripitions.order_id')
            ->join('book_details', 'book_details.id', '=', 'order_descripitions.book_id')
            ->selectRaw('order_details.*,
                order_descripitions.book_quantity,
                book_details.book_name,
                book_details.book_title,
                book_details.author_name,
                book_details.book_edition,
                book_details.description,
                book_details.book_cover,
                book_details.book_price,
                book_details.book_language,
                book_details.book_type,
                book_details.book_discount
                ')
            ->where('order_details.user_id', $userId)->where('order_details.id', $orderId)->distinct('order_descripitions.book_id')->get()->toArray();

        return view('User.order_more_info')->with(compact('data'));
    }


    public function invoice()
    {
        return view('User.userLayout.invoice_email');
    }
}
