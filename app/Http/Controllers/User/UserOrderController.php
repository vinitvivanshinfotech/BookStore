<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ShippingDetailsRequest;
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
use App\Models\ShippingDetails;


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
     * Desciption : 
     * 
     * @param : App\Http\Requests\ShippingDetailsRequest $request
     * @return : 
     */
    public function makeAnOrder(ShippingDetailsRequest $request)
    {
        $userId = Auth::user()->id;
        try {
            $paymentId = PaymentBook::create([
                'user_id' => $userId,
                'payment_mode' => $request->input('payment_mode'),
            ])->id;

            if (empty($paymentId)) {
                return redirect()->back()->with('failure', "Something went wrong while adding your payment details.");
            }

            Log::info('user ' . $userId . " payment book id " . $paymentId . " created");

            $totalOrderedBookQty = Cart::where('user_id', $userId)->sum('book_quantity');
            $totalOrderedBookPrice = Cart::join('book_details', 'carts.book_id', '=', 'book_details.id')->selectRaw('SUM(carts.book_quantity * book_details.book_price) as total ')->first()->total;


            $orderDetails = OrderDetail::create([
                'user_id' => $userId,
                'book_total_price' => $totalOrderedBookPrice,
                'book_total_quantity' =>  $totalOrderedBookQty,
                'book_shipdate' => Carbon::now()->addDays(2),
                'book_billdate' =>  Carbon::now(),
                'payment_id' => $paymentId,
                'order_status' => 'Placed Order'
            ]);

            Log::info('user ' . $userId . " order" . $orderDetails->id . " created");


            $cartitems = Cart::where('user_id', $userId)->get()->toArray();
            foreach ($cartitems as $item) {

                OrderDescripition::create([
                    'order_id' => $orderDetails->id,
                    'book_id' => $item['book_id'],
                    'book_quantity' => $item['book_quantity'],
                ]);
                Log::debug($item['book_quantity']);
            }

            Cart::where('user_id', $userId)->delete();

            $shippingDetails=ShippingDetails::create([
                'order_id' => $orderDetails->id ,
                'first_name' =>$request->input('first_name'),
                'last_name' =>$request->input('last_name'),
                'email'=>$request->input('email'),
                'phone_number'=>$request->input('phone_number'),
                'address'=>$request->input('address'),
                'pincode'=>$request->input('pincode'),
                'city'=>$request->input('city'),
                'state'=>$request->input('state'),
            ]);




            Log::debug('user' . $userId . 'has no of book order ' . $totalOrderedBookQty);
        } catch (\Exception $th) {
            Log::error(__METHOD__ . 'line' . __LINE__ . "Error in making an order" . $th->getMessage());
            Session::flash("failure", 'Something went wrong!');
        }
    }
}
