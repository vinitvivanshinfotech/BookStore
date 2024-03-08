<?php

namespace App\Repositories\Interfaces;

// Models
use App\Models\PaymentBook;

interface PaymentBookRepositoryInterface{

    /**
     * Desciption : getModel  Get user model query builder
     * 
     * @param : boolean $archived
     * @return : \Illuminate\Database\Eloquent\Builder
     */ 
    public function getModel();

     /**
     * Desciption : Create a new payment 
     * 
     * @param : int $userId
     * @param : int $paymentMode
     * @return : Illuminate\Database\Eloquent\Model
     */ 
    public function create($userId,$paymentMode);
}