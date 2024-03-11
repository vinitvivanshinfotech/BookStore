<?php

namespace App\Repositories;

use Carbon\Carbon;

// Models
use App\Models\OrderDetail;
use App\Models\OrderDescripition;
use App\Models\BookDetail;

// Interface
use App\Repositories\Interfaces\OrderDetailRepositoryInterface;

class OrderDetailRepository implements OrderDetailRepositoryInterface{

    protected $bookDetails;

    public function __construct(
        OrderDetail $orderDetails,
    ){
        $this->orderDetails = $orderDetails;
    }

    /**
     * Desciption : getModel -> get the model query  builder
     * 
     * @param : 
     * @return : 
     */ 

    public function getModel(){
        return $this->orderDetails; 
    }

    /**
     * Desciption : Create a new instance of the model OrderDetail 
     * 
     * @param : $userId
     * @param : $amountToBepay
     * @param : $totalOrderedBookQty
     * @param : $paymentId
     * @return : 
     */ 
    public function create($userId,$amountToBepay,$totalOrderedBookQty,$paymentId){
        return $this->orderDetails->getModel()->create([
            'user_id' => $userId,
            'book_total_price' => $amountToBepay,
            'book_total_quantity' =>  $totalOrderedBookQty,
            'book_shipdate' => Carbon::now()->addDays(2),
            'book_billdate' =>  Carbon::now(),
            'payment_id' => $paymentId,
            'order_status' => 'Placed Order'
        ]);
    }

    /**
     * Desciption : get order all details
     * 
     * @param : int $userId
     * @param : int $orderId
     * @return : array
     */ 
    public function getOrderAllDetails($userId, $orderId){
        return $this->getModel()->join('order_descripitions', 'order_details.id', '=', 'order_descripitions.order_id')
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
    }




}