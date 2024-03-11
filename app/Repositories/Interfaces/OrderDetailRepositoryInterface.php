<?php

namespace App\Repositories\Interfaces;

// Models
use App\Models\OrderDetail;

interface OrderDetailRepositoryInterface{

    /**
     * Desciption : getModel  Get user model query builder
     * 
     * @param : boolean $archived
     * @return : \Illuminate\Database\Eloquent\Builder
     */ 
    public function getModel();

    /**
     * Desciption : Create a new instance of the model OrderDetail 
     * 
     * @param : $userId
     * @param : $amountToBepay
     * @param : $totalOrderedBookQty
     * @param : $paymentId
     * @return : 
     */ 
    public function create($userId,$amountToBepay,$totalOrderedBookQty,$paymentId);

    /**
     * Desciption : get order all details
     * 
     * @param : int $userId
     * @param : int $orderId
     * @return : array
     */ 
    public function getOrderAllDetails($userId, $orderId);
}
