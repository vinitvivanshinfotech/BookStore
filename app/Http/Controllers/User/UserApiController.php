<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// model
use App\Models\WishlistBook;
use App\Models\Cart;

class UserApiController extends Controller
{
    /**
     * Desciption : 
     * 
     * @param : $user_id int,$book_id string
     * @return : json
     */
    public function addToWishlist($user_id, $book_id)
    {

        $data = WishlistBook::where(["user_id" => $user_id, "book_id" => $book_id])->first();

        if ($data == null) {
            // insert data to wishlist table

            $listItem = WishlistBook::create([
                'user_id' => $user_id,
                'book_id' => $book_id
            ]);

            if ($listItem != NULL) {
                return  response()->json(['status' => "success"]);
            } else {
                return  response()->json(['status' => "failed"], 500);
            }
        } else {
            return  response()->json(['status' => "exists"]);
        }
    }

    /**
     * Desciption : 
     * 
     * @param : $user_id int,$book_id int
     * @return : json
     */
    public function addToCart($user_id, $book_id)
    {

        $data = Cart::where(["user_id" => $user_id, "book_id" => $book_id])->first();

        if ($data == NULL) {
            $listItem = Cart::create([
                'user_id' => $user_id,
                'book_id' => $book_id
            ]);

            if ($listItem != NULL) {
                return  response()->json(['status' => "success"]);
            } else {
                return  response()->json(['status' => "failed"], 500);
            }
        }else{
            return  response()->json(['status' => "exists"]);
        }
    }
}
