<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingDetail extends Model
{
    use HasFactory;

    protected $guarded = [
        

    ];

    public function orderDetails(){
        return $this->belongsToMany(OrderDetail::class);
    }
}
