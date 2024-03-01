<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewBook extends Model
{
    use HasFactory;

    protected $guarded = [ 
        
    ];

    public function book(){
        $this->belongsTo(BookDetail::class);
    }

    public function  user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
