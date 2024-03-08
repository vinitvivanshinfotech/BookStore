<?php

namespace App\Repositories;

// Models
use App\Models\PaymentBook;

// Interface
use App\Repositories\Interfaces\PaymentBookRepositoryInterface;

class PaymentBookRepository implements PaymentBookRepositoryInterface{

    protected $paymentBook;

    public function __construct(
        PaymentBook $paymentBook,
    ){
        $this->paymentBook = $paymentBook;
    }

    /**
     * Desciption : getModel -> get the model query  builder
     * 
     * @param : 
     * @return : Model
     */ 

    public function getModel(){
        return $this->paymentBook; 
    }


    /**
     * Desciption : Create a new payment 
     * 
     * @param : int $userId
     * @param : int $paymentMode
     * @return : Illuminate\Database\Eloquent\Model
     */ 
    public function create($userId,$paymentMode){
        return $this->paymentBook->create([
            'user_id' => $userId,
            'payment_mode' => $paymentMode
        ]);
    }




}