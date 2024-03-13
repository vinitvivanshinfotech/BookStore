<?php

namespace App\Repositories\Interfaces;

// Models
use App\Models\Cart;

interface CartRepositoryInterface{

    /**
     * Desciption : getModel  Get user model query builder
     * 
     * @param : boolean $archived
     * @return : \Illuminate\Database\Eloquent\Builder
     */ 
    public function getModel();


    /**
     * Desciption : getBookIdOfCartItems 
     * 
     * @param : int $userId
     * @return : array $bookId
     */ 

     public function getBookIdOfCartItems($userId);

     /**
      * Desciption : getCartTotalDetails() get the total of cart items-quantity, total-items-price, total-items-discount
      * 
      * @param : int $userId
      * @return : 
      */ 
      public function getCartTotalDetails($userId);

      /**
     * Desciption : get Cart Item all details
     * 
     * @param : int $userId
     * @return : 
     */ 
    public function getCartItemAllDetails($userId);

    /**
     * Desciption : delete all items present in cart of specified user
     * 
     * @param : int $userId
     * @return : boolean
     */ 
    public function deleteCartAllItem($userId);

     
}