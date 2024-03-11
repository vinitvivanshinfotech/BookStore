<?php

namespace App\Repositories;

// Models
use App\Models\Cart;
use App\Models\BookDetail;

// Interface
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\BookDetailRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{

    protected $user;

    public function __construct(
        Cart $cart,
        BookDetail $bookDetail
    ) {
        $this->cart = $cart;
        $this->bookDetail = $bookDetail;
    }

    /**
     * Desciption : getModel -> get the model query  builder
     * 
     * @param : 
     * @return : 
     */

    public function getModel()
    {
        return $this->cart;
    }

    /**
     * Desciption : getBookIdOfCartItems 
     * 
     * @param : int $userId
     * @return : array $bookId
     */

    public function getBookIdOfCartItems($userId)
    {
        return $this->cart->where('user_id', $userId)->pluck('book_id')->toArray();
    }

    /**
     * Desciption : getCartTotalDetails() get the total of cart items-quantity, total-items-price, total-items-discount
     * 
     * @param : int $userId
     * @return : 
     */
    public function getCartTotalDetails($userId)
    {
        return $this->getModel()->join('book_details', 'carts.book_id', '=', 'book_details.id')->where('user_id', $userId)
            ->selectRaw('SUM(carts.book_quantity) as total_ordered_book_qty,
                        SUM(carts.book_quantity * book_details.book_discount) as total_ordered_book_discount,
                        SUM(carts.book_quantity * book_details.book_price) as total_ordered_book_price')
            ->first();
    }

    /**
     * Desciption : get Cart Item all details
     * 
     * @param : int $user_id
     * @return : 
     */ 
    public function getCartItemAllDetails($userId){
        return $this->getModel()->where('user_id', $userId)->get();
    }

    /**
     * Desciption : delete all items present in cart of specified user
     * 
     * @param : int $userId
     * @return : boolean
     */ 
    public function deleteCartAllItem($userId){
        return $this->getModel()->where('user_id', $userId)->delete();
    }
}
