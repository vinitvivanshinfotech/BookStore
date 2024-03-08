<?php

namespace App\Repositories;

// Models
use App\Models\WishlistBook;

// Interface
use App\Repositories\Interfaces\WishlistBookRepositoryInterface;

class WishlistBookRepository implements WishlistBookRepositoryInterface{

    protected $user;

    public function __construct(
        WishlistBook $wishlistBook,
    ){
        $this->wishlistBook = $wishlistBook;
    }

    /**
     * Desciption : getModel -> get the model query  builder
     * 
     * @param : 
     * @return : 
     */ 

    public function getModel(){
        return $this->wishlistBook; 
    }




}