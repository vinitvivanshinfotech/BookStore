<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Exceptions;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;


// Import Models
use App\Models\BookDetail;
use App\Models\WishlistBook;
use App\Models\Cart;

class UserController extends Controller
{
    /**
     * Desciption return user dashboard: 
     * 
     * @param
     * @return : user dashboard view
     */
    public function dashboard()
    {
        return view('User.dashboard');
    }


    /**
     * Desciption : retun all books page to the user 
     * 
     * @param
     * @return \view all books
     */
    public function displayAllBooks()
    {
        $cartBookIds = Cart::where('user_id',auth()->user()->id)->pluck('book_id');
        $books = BookDetail::whereNotIn('id',$cartBookIds)->simplePaginate(6);
        // Return the View with Data
        return view("User.all_books")->with(compact('books'));
    }

    /**
     * Desciption : Return the details of book having id = $book_id
     * 
     * @param : $book_id
     * @return : view
     */

    public function bookDetails(Request $request)
    {
        $book_id = $request->input('book_id');
        $bookDetails = BookDetail::find($book_id);
        return view("User.book_details")->with(compact('bookDetails'));
    }


    /**
     * Desciption : return watchlist of auth user with booklist
     * 
     * @param : 
     * @return : view with wishlist data
     */
    public function myWatchlist()
    {
        $userId = auth()->id();
        $wishListData = WishlistBook::where('user_id', $userId)->with(['bookDetails'])->get()->toArray();
        return view('User.my_watchlist')->with('data', $wishListData);
    }

    /**
     * Desciption : return cart  list of auth user with booklist and quantity
     * 
     * @param : 
     * @return : view with cart data
     */
    public function myCart()
    {
        $userId = auth()->id();
        $cartData = Cart::where('user_id', $userId)->with(['bookDetails'])->get()->toArray();
        return view('User.my_cart')->with('data', $cartData);
    }

    /**
     * Desciption : 
     * 
     * @param : 
     * @return : 
     */
    public function quantityChange(Request $request)
    {

        $action = $request->action;
        $cartItem = Cart::find($request->cart_id);
        if ($action === 'increse') {
            $cartItem['book_quantity'] = $cartItem['book_quantity'] + 1;
            $cartItem->save();
            return redirect()->route('user.cart');
        } else if ($action === 'decrease') {
            if ($cartItem->book_quantity <= 1) {
                $cartItem->delete();
                return redirect()->route('user.cart');
            } else {
                $cartItem['book_quantity'] = $cartItem['book_quantity'] - 1;
                $cartItem->save();
                return redirect()->route('user.cart');
            }
        } else {
            return back()->route('user.cart')->with('failure', 'Item doet not  exist in cart');
        }
    }


    /**
     * Desciption : 
     * 
     * @param : 
     * @return : 
     */
    public function removeFromWatchlist(Request $request)
    {
        try {
            $watchlistId = $request->input('wishlist_id');
            WishlistBook::destroy($watchlistId);
            Log::info(__METHOD__ . "User" . Auth::user()->name . ' removed a book from his/her wishlist, Watchlist ID:' . $watchlistId);
            return redirect()->route('user.watchlist')->with('success', 'Removed from Watchlist Successfully.');
        } catch (\Exception $th) {
            Log::error(__LINE__ . ':' . __FILE__ . ':' . $th->getMessage());
            return redirect()->route('user.watchlist')->with('failure', 'Something went wrong! Please try again later.');
        }
    }


    /**
     * Desciption : 
     * 
     * @param : 
     * @return : 
     */
    public function removeFromCart(Request $request)
    {
        try {
            $cartId = $request->input('cart_id');
            Cart::destroy($cartId);
            Log::info(__METHOD__ . "User" . Auth::user()->name . ' removed a book from his/her cart, Watchlist ID:' . $cartId);
            return redirect()->route('user.cart')->with('success', 'Removed from cart Successfully.');
        } catch (\Exception $th) {
            Log::error(__LINE__ . ':' . __FILE__ . ':' . $th->getMessage());
            return redirect()->route('user.cart')->with('failure', 'Something went wrong! Please try again later.');
        }
    }
}
