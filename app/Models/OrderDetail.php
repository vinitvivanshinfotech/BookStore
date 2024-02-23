<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_total_price',
        'book_total_quantity',
        'book_shipdate',
        'book_billdate',
        'payment_id',
        'order_status'

    ];



    public function user(){

        return $this->belongsTo(User::class,);
    }
    public function book(){
        return $this->belongsTo(BookDetail::class);
    }
}
