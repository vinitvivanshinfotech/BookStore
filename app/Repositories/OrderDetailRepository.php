<?php

namespace App\Repositories;

use Carbon\Carbon;

// Models
use App\Models\OrderDetail;

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




}