<?php

namespace App\Repositories\Interfaces;

// Models
use App\Models\ShippingDetail;

interface ShippingDetailRepositoryInterface{

    /**
     * Desciption : getModel  Get user model query builder
     * 
     * @param : boolean $archived
     * @return : \Illuminate\Database\Eloquent\Builder
     */ 
    public function getModel();
}