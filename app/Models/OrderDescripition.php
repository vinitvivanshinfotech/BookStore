<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDescripition extends Model
{
    use HasFactory;
    
    protected $guarded = [
       
    ];

    public function bookDetails(){
        $this->belongsTo(BookDetail::class, 'book_id');
    }
}
