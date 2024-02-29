<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'book_quantity'
    ];

    public function bookDetails(){
        return $this->belongsTo(BookDetail::class, 'book_id');
    }
}
