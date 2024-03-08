<?php

namespace App\Repositories;

// Models
use App\Models\Cart;

// Interface
use App\Repositories\Interfaces\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface{

    protected $user;

    public function __construct(
        Cart $cart,
    ){
        $this->cart = $cart;
    }

    /**
     * Desciption : getModel -> get the model query  builder
     * 
     * @param : 
     * @return : 
     */ 

    public function getModel(){
        return $this->cart; 
    }

    /**
     * Desciption : getBookIdOfCartItems 
     * 
     * @param : int $userId
     * @return : array $bookId
     */ 

     public function getBookIdOfCartItems($userId){
        return $this->cart->where('user_id',$userId)->pluck('book_id')->toArray();
    }

}