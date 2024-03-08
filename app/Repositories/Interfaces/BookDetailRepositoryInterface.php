<?php

namespace App\Repositories\Interfaces;

// Models
use App\Models\Cart;

interface BookDetailRepositoryInterface{

    /**
     * Desciption : getModel  Get user model query builder
     * 
     * @param : boolean $archived
     * @return : \Illuminate\Database\Eloquent\Builder
     */ 
    public function getModel();
}