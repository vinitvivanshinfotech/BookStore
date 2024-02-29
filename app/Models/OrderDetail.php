<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded = [
        
    ];



    public function user(){

        return $this->belongsTo(User::class);
    }
    public function book(){
        return $this->belongsTo(BookDetail::class);
    }

    public function orderDescription(){
        return $this->hasMany(OrderDescripition::class,'order_id');
    }
}
