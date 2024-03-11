<?php

namespace App\Http\Controllers\User;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ShippingDetailsRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Imports\UserImport;
use App\Exports\UserExport;
use Excel;
use Stripe\PaymentIntent;
use Stripe\Stripe;

// Interface
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\WishlistBookRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\BookDetailRepositoryInterface;
use App\Repositories\Interfaces\PaymentBookRepositoryInterface;
use App\Repositories\Interfaces\OrderDetailRepositoryInterface;
use App\Repositories\Interfaces\OrderDescripitionRepositoryInterface;
use App\Repositories\Interfaces\ShippingDetailRepositoryInterface;


// Model
use App\Models\User;
use App\Models\BookDetail;
use App\Models\PaymentBook;
use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\OrderDescripition;
use App\Models\ShippingDetail;
use App\Models\ReviewBook;

// Mail
use App\Mail\OrderPlacedPdf;
use PhpParser\Node\Expr\Cast\Bool_;

class UserOrderController extends Controller
{
    public function __construct(
        UserRepositoryInterface $user,
        CartRepositoryInterface $cart,
        WishlistBookRepositoryInterface $wishlistBook,
        BookDetailRepositoryInterface $bookDetail,
        PaymentBookRepositoryInterface $paymentBook,
        OrderDetailRepositoryInterface $orderDetails,
        OrderDescripitionRepositoryInterface $orderDescription,
        ShippingDetailRepositoryInterface $shippingDetails,
    ) {
        $this->user = $user;
        $this->cart = $cart;
        $this->wishlistBook = $wishlistBook;
        $this->bookDetail = $bookDetail;
        $this->paymentBook = $paymentBook;
        $this->orderDetails = $orderDetails;
        $this->orderDescription = $orderDescription;
        $this->shippingDetails = $shippingDetails;
    }

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
            DB::beginTransaction();

            // Retrieve the cart details of user
            $cartitems = $this->cart->getCartItemAllDetails($userId);
            if ($cartitems == null || count($cartitems) == 0) {
                return redirect()->back()->with('failure', __('messages.empty_cart'));
            }

            // Make Payment
            $paymentId = $this->paymentBook->create($userId,$request->input('payment_mode'))->id;
            if (empty($paymentId)) {
                Log::info('payment failed of user = ' . $userId . " ");
                return redirect()->back()->with('failure', __('messages.payment_fail'));
            }

            // Details about Some Of Cart Items,total_price,total_discount,total_quantity
            $cart = $this->cart->getCartTotalDetails($userId);

            $totalOrderedBookQty = $cart->total_ordered_book_qty;
            $totalOrderedBookDiscount = $cart->total_ordered_book_discount;
            $totalOrderedBookPrice = $cart->total_ordered_book_price;
            $amountToBepay = $totalOrderedBookPrice - $totalOrderedBookDiscount;

            // Create the order details
            $orderDetails = $this->orderDetails->create($userId,$amountToBepay,$totalOrderedBookQty,$paymentId);
            $orderId = $orderDetails->id;
            if (empty($orderDetails)) {
                Log::info('orderdetails addintion failed of = ' . $userId . " ");
                return redirect()->back()->with('failure', __('messages.order_fail'));
            }

            // Create the order description of $orderId
            $orderDescriptioAdd = $this->orderDescription->create($userId,$orderId);
            if (empty($orderDescriptioAdd)) {
                Log::info('orderdescription addintion failed of = '. $userId. " ");
                return redirect()->back()->with('failure', __('messages.order_fail'));
            }

            $postData = $request->except('_token', 'payment_mode');
            $postData['order_id'] = $orderDetails->id;

            // Create shipping details information
            $shippingDetails = $this->shippingDetails->create($postData);

            if (empty($shippingDetails)) {
                Log::info('shippingDetails addintion failed of = ' . $userId . " ");
                return redirect()->back()->with('failure', __('messages.shipping_details_add_fail'));
            }

            // SEND THE ORDER DETAILS TO THE ADMIN
            $orderId =  $orderDetails->id;
            $data = $this->orderDetails->getOrderAllDetails($userId, $orderId);

            // MAKE INVOICE PDF
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
            
            // Emptying Cart of User
            $this->cart->deleteCartAllItem($userId);

            return redirect()->route('user.myOrders')->with('success', 'Order placed successfully');
        } catch (\Exception $th) {
            DB::rollBack();
            Log::error(__METHOD__ . 'line' . __LINE__ . " Error in making an order" . $th->getMessage());
            Session::flash("failure", 'Something went wrong!');
        }
    }


    public  function MakePayment(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentId = $request->paymentId;
        $orderId = $request->orderId;


        $paymentIntent = PaymentIntent::create([
            'amount' => $request->book_total_price,
            'currency' => 'usd',
            'metadata' => [
                'order_id' => $orderId,
                'payment_id' => $paymentId,
            ],
        ]);
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
     * Desciption : Return all information about  a particular order
     *              and show it to the user who placed that order
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
                book_details.id as book_details_id,
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

    /**
     * Desciption : 
     * 
     * @param : 
     * @return : 
     */
    public function addBookReview(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'book_ratings' => ['required'],
            'book_comments' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->all());
        }

        // Insert into Review table
        $data = $request->except('_token');
        $review = ReviewBook::create($data);
    }
}
