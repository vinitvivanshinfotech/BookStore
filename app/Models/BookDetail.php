<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookDetail extends Model
{
    use HasFactory;
    protected $table = 'book_details';
    protected $fillable =['book_name','book_title', 'author_name', 'author_email','book_edition','description','book_cover','book_price','book_language','book_type'];
}
