<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishlistBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id'
    ];

    public function bookDetails(){
        return $this->belongsTo(BookDetail::class, 'book_id');
    }
}
