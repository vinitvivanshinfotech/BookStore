<?php

namespace App\Http\Controllers\User;

//  Models
use App\Models\BookDetail;
use App\Models\WishlistBook;
use App\Models\Cart;
use App\Models\ReviewBook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Exceptions;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

// Requests
use App\Http\Requests\RegisterRequest;

// Interface
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\WishlistBookRepositoryInterface;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\BookDetailRepositoryInterface;

class UserController extends Controller
{
    public function __construct(
        UserRepositoryInterface $user,
        WishlistBookRepositoryInterface $wishlistBook,
        CartRepositoryInterface $cart,
        BookDetailRepositoryInterface $bookDetail,
    ) {
        $this->user = $user;
        $this->wishlistBook = $wishlistBook;
        $this->cart = $cart;
        $this->bookDetail = $bookDetail;
    }


    /**
     * Desciption : Get user profile    
     * 
     * @param : 
     * @return : User.myProfile view
     */
    public function myProfile()
    {
        $user = Auth::user();
        return view('User.myProfile', compact('user'));
    }

    /**
     * Desciption : Update user profile  
     * 
     * @param : 
     * @return : User.myProfile view
     */
    public function updateProfile(RegisterRequest $request)
    {
        try {
            $data = $request->except(['_token']);
            $this->user->update($data);
            return redirect()->route('user.profile')->with('success', "Profile updated");
        } catch (Exception $e) {

        };
    }




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
        try{$booksInCart = $this->cart->getModel()->where('user_id', Auth::user()->id)->pluck('book_id')->toArray();
        $booksInWishlist = $this->wishlistBook->getModel()->where('user_id', Auth::user()->id)->pluck('book_id')->toArray();
        // $books = BookDetail::whereNotIn('id',$cartBookIds)->simplePaginate(6);
        $books = $this->bookDetail->getModel()->leftJoin('review_books', 'book_details.id', '=', 'review_books.book_id')->selectRaw('book_details.*,AVG(review_books.book_ratings) as ratings')->whereNotIn('book_details.id', $booksInCart)->groupBy('book_details.id')->simplePaginate(10);
        // Return the View with Data
        return view("User.all_books")->with(compact('books', 'booksInCart', 'booksInWishlist'));
        }catch(Exception $e){
            Log::error(__METHOD__.'Line : '.__LINE__.' Error while displaying Bookdetails '.$e->getMessage());
            return redirect()->route('user.internal-serrver-error');
        };
    }

    /**
     * Desciption : Return the details of book having id = $book_id
     * 
     * @param : $book_id
     * @return : view
     */

    public function bookDetails(Request $request)
    {
        $bookId = $request->input('book_id');
        $booksInCart = $this->cart->getModel()->where('user_id', Auth::user()->id)->pluck('book_id')->toArray();
        $booksInWishlist = $this->wishlistBook->getModel()->where('user_id', Auth::user()->id)->pluck('book_id')->toArray();

        $bookDetails = $this->bookDetail->getModel()->where('id', $bookId)->with(['reviewbooks.user'])->first();

        return view("User.book_details")->with(compact('bookDetails', 'booksInCart', 'booksInWishlist'));
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
        $booksInCart = $this->cart->getBookIdOfCartItems($userId);
        $wishListData = $this->wishlistBook->getModel()->where('user_id', $userId)->with(['bookDetails'])->get()->toArray();
        return view('User.my_watchlist')->with(['data' => $wishListData, 'booksInCart' => $booksInCart]);
        // return view('User.my_watchlist');
    }

    /**
     * Desciption : Accept My watchlist Ajax call request and return  response
     * 
     * @param : 
     * @return : 
     */
    public function myWatchlistAjax(Request $request)
    {

        $draw_val = $request->input('draw');

        $booksInCart = $this->cart->getBookIdOfCartItems(Auth::user()->id);


        $totalDataRecord = $totalFilterdRecord = $draw_val = "";

        $column_list = array(
            0 => "book_cover",
            1 => "book_name",
            2 => "author_name",
            3 => "book_price",
            4 => "book_discount",
            5 =>  "more",
            6 => "remove",
            7 => "add_to_cart"
        );

        $totalDataRecord = WishlistBook::count();
        $totalFilterdRecord = $totalDataRecord;

        $limit_val = $request->input('length');
        $start_val = $request->input('start');
        $order_val = $column_list[$request->input('order.0.column')];
        if ($order_val == 'book_cover' || $order_val == 'more' || $order_val == 'remover' || $order_val == 'add_to_cart') {
            $order_val = 'book_name';
        }
        $dir_val = $request->input('order.0.dir');
        $search_val = $request->input('search.value');

        if (empty($search_val)) {
            $wishlistData = WishlistBook::join('book_details', 'wishlist_books.book_id', '=', 'book_details.id')
                ->where('wishlist_books.user_id', auth()->user()->id)
                ->select('wishlist_books.id as listId', 'wishlist_books.*', 'book_details.*')
                ->offset($start_val)
                ->limit($limit_val)
                ->orderBy($order_val, $dir_val)
                ->get();
        } else {
            $wishlistData = WishlistBook::join('book_details', 'wishlist_books.book_id', '=', 'book_details.id')
                ->where('wishlist_books.user_id', auth()->user()->id)
                ->where(function ($query) use ($search_val) {
                    $query->where("book_details.book_name", "like", "%" . $search_val . "%")
                        ->orWhere("book_details.author_name", "like", "%" . $search_val . "%")
                        ->orWhere("book_details.book_price", "like", "%" . $search_val . "%")
                        ->orWhere("book_details.book_discount", "like", "%" . $search_val . "%");
                })
                ->select('wishlist_books.id as listId', 'wishlist_books.*', 'book_details.*')
                ->offset($start_val)
                ->limit($limit_val)
                ->orderBy($order_val, $dir_val)
                ->get();


            $totalFilterdRecord = count($wishlistData);
        }


        $data = [];
        foreach ($wishlistData as $listItem) {
            $raw = [
                'book_cover' => '<img class="card-img-top mt-1 mb-1 ms-1 mr-1" src="' . Storage::disk(config('constant.FILESYSTEM_DISK'))->url($listItem['book_cover']) . '" onerror="this.src=\'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQTUUcQuoOAi8EgqOQ6epycAwp8T9WaxN7IkA&usqp=CAU\';" alt="Card image cap" height="100px" width="50px">',
                'book_name' => $listItem['book_name'],
                'author_name' => $listItem['author_name'],
                'book_price' => $listItem['book_price'],
                'book_discount' => $listItem['book_discount'],
                'more' => '<form action="' . route('user.bookDetails') . '" method="GET">' .
                    csrf_field() .
                    '<input type="hidden" id="book_id" name="book_id" value="' . $listItem['id'] . '">' .
                    '<button type="submit" class="btn-sm btn-secondary" id="showBookDetails" name="showBookDetails" value="">' .
                    '<i class="bi bi-eye-fill mr-1"></i>' . __('labels.more') .
                    '</button></form>',
                'remove' => '<form class="mt-1" action="' . route('user.removeFromWatchlist') . '" method="POST">' .
                    csrf_field() .
                    '<input type="hidden" id="wishlist_id" name="wishlist_id" value="' . $listItem['listId'] . '">' .
                    '<button type="submit" class="btn-sm btn-danger mt-2 mb-3 " id="" name="">' .
                    '<i class="bi bi-trash3-fill mr-1"></i>' . __('labels.remove_from_list') .
                    '</button></form>',
                'add_to_cart' => '<span class="text-success addedSpan ' . $listItem['id'] . '"></span>' .
                    '<button class="btn-sm btn-warning mt-2 mb-3 addToCartButton ' . $listItem['id'] . '" id="addToCartButton" name="addToCartButton" value="' . $listItem['id'] . '" ' . (in_array($listItem['id'], $booksInCart) ? 'disabled' : '') . '>' .
                    '<i class="bi bi-cart-plus-fill mr-1 cartStatus ' . $listItem['id'] . '"></i>' . (in_array($listItem['id'], $booksInCart) ? 'ADDED' : 'Cart') .
                    '</button>'
            ];
            $data[] = $raw;
        }
        $data = [
            'draw' => $request->input('draw'),
            'recordsTotal' => intval($totalDataRecord),
            'recordsFiltered' => intval($totalFilterdRecord),
            'data' => $data
        ];
        // echo json_encode($data);
        return response()->json($data);
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
        $cartData = $this->cart->getModel()->where('user_id', $userId)->with(['bookDetails'])->get()->toArray();
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
        $cartItem = $this->cart->getModel()->find($request->cart_id);
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
            return readdir()->route('user.cart')->with('failure', 'Item doet not  exist in cart');
        }
    }


    /**
     * Desciption : Remove Item from Watchlist
     * 
     * @param : Illuminate\Http\Request  $request
     * @return : View
     */
    public function removeFromWatchlist(Request $request)
    {
        try {
            $watchlistId = $request->input('wishlist_id');
            $this->wishlistBook->getModel()->destroy($watchlistId);
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
            $this->cart->getModel()->destroy($cartId);
            Log::info(__METHOD__ . "User" . Auth::user()->name . ' removed a book from his/her cart, Watchlist ID:' . $cartId);
            return redirect()->route('user.cart')->with('success', 'Removed from cart Successfully.');
        } catch (\Exception $th) {
            Log::error(__LINE__ . ':' . __FILE__ . ':' . $th->getMessage());
            return redirect()->route('user.cart')->with('failure', 'Something went wrong! Please try again later.');
        }
    }
}
