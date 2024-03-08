<?php

namespace App\Repositories\Interfaces;

// Models
use App\Models\OrderDescripition;

interface OrderDescripitionRepositoryInterface{

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
     * @param : int $userId
     * @param : int $orderId
     * @return : 
     */ 
    public function create($userId,$orderId);
}