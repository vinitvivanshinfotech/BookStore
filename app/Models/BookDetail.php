<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function reviewbooks(){
        return  $this->hasMany(ReviewBook::class,'book_id');
    }
}
