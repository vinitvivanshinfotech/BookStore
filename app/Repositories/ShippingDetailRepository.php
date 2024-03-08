<?php

namespace App\Repositories;

// Models
use App\Models\ShippingDetail;

// Interface
use App\Repositories\Interfaces\ShippingDetailRepositoryInterface;

class ShippingDetailRepository implements ShippingDetailRepositoryInterface
{

    protected $shippingDetails;

    public function __construct(
        ShippingDetail $shippingDetails,
    ) {
        $this->shippingDetails = $shippingDetails;
    }

    /**
     * Desciption : getModel -> get the model query  builder
     * 
     * @param : 
     * @return : 
     */
    public function getModel()
    {
        return $this->shippingDetails;
    }

    /**
     * Desciption : create a new shipping details object
     * 
     * @param : array : shippingDetailsAttributes
     * @return : 
     */ 
    public function create($shippingDetailsAttributes){
        return $this->getModel()->create($shippingDetailsAttributes);
    }
}
