<?php

namespace App\Repositories;

// Models
use App\Models\BookDetail;

// Interface
use App\Repositories\Interfaces\BookDetailRepositoryInterface;

class BookDetailRepository implements BookDetailRepositoryInterface{

    protected $bookDetails;

    public function __construct(
        BookDetail $bookDetails,
    ){
        $this->bookDetails = $bookDetails;
    }

    /**
     * Desciption : getModel -> get the model query  builder
     * 
     * @param : 
     * @return : 
     */ 

    public function getModel(){
        return $this->bookDetails; 
    }




}