<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'address',
        'pincode',
        'city',
        'state',

    ];
}
