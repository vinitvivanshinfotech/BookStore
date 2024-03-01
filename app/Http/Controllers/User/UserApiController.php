<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

// model
use App\Models\WishlistBook;
use App\Models\Cart;
use App\Models\ReviewBook;



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
                return  response()->json([
                    'status' => "success",
                    'book_id' => $book_id,
                ]);
            } else {
                return  response()->json([
                    'status' => "failed",
                    'book_id' => $book_id,
                ], 500);
            }
        } else {
            return  response()->json([
                'status' => "exists",
                'book_id' => $book_id,
            ]);
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
        $deletdFromWishlist = WishlistBook::where('book_id',$book_id)->delete();
        if ($data != null) {
            $data->book_quantity = $data->book_quantity + 1;
            $data->save();
            return  response()->json([
                'status' => "exists",
                'book_id' => $data->book_id,
            ], 200);
        }else {

            try {
                $listItem = Cart::create([
                    'user_id' => $user_id,
                    'book_id' => $book_id,
                    'book_quantity' => 1,
                ]);
                Log::info('Added book to cart: by ' .$user_id.' book id '.$book_id);
                if ($listItem != NULL) {
                    return  response()->json([
                        'status' => "success",
                        'book_id' => $listItem->book_id,
                    ],200);
                } else {
                    return  response()->json(['status' => "failed"], 500);
                }
            } catch (\Exception $th) {
                Log::error(__METHOD__ . ',' . __LINE__ . '-' . $th->getMessage());
            }
        }
    }

    /**
     * Desciption : Get the data of watchlist and cart data of authenticated user
     * 
     * @param : 
     * @return : json
     */ 

     public function getWatchlistCartData(Request $request){
        $userId = $request->user_id;
        $cartItems = Cart::where('user_id',$userId)->get()->toArray();
        
        $wishlistItems = WishlistBook::where('user_id',$userId)->get()->toArray();

        return response()->json([
            'status'=>'success',
            'cartCount' => count($cartItems),
            'wishlistCount' => count($wishlistItems)
        ]);
     }

     public function addRatings(Request $request){
        
        {
            $review = ReviewBook::create([
                'user_id'       => $request->user_id,
                'book_id'       => $request->book_id,
                'book_ratings' => $request->rating ?? '',
                'book_comments' => $request->review ?? ''
            ]);
            if($review){
                return response()->json([
                    'status'=>'success',
                ],200);
            }else{
                return response()->json([
                    'status'=>'fail',
                ],501);
            }
        }
     }
}
