<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\View;
use App\Models\ShippingDetail;
use App\Mail\SendInvoiceToUser;

use Illuminate\Http\Request;

class SendInvoiceController extends Controller
{
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

}
