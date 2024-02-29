<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDescripition extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'order_id',
        'book_id',
        'book_quantity'
    ];

    public function bookDetails(){
        $this->belongsTo(BookDetail::class, 'book_id');
    }
}
