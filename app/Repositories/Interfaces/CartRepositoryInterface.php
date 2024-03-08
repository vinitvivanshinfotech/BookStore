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
}