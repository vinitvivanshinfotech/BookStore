<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\ShippingDetail;


trait InvoiceDetails
{

    public function InvoiceDetails($id)
    {
        $orderDetails = ShippingDetail::join('order_details', 'order_details.id', '=', 'shipping_details.order_id')
            ->join('payment_books', 'payment_books.id', '=', 'order_details.payment_id')
            ->join('order_descripitions', 'order_descripitions.order_id', '=', 'order_details.id')
            ->join('book_details', 'book_details.id', '=', 'order_descripitions.book_id')->where('shipping_details.order_id', $id)
            ->get();
        return response()->json($orderDetails);
    }
}
