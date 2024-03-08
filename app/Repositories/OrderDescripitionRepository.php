<?php

namespace App\Repositories;

use Carbon\Carbon;

// Models
use App\Models\OrderDescripition;
use App\Models\Cart;

// Repositories
use App\Repositories\CartRepository;

// Interface
use App\Repositories\Interfaces\OrderDescripitionRepositoryInterface;
use Exception;
use PhpParser\Node\Stmt\TryCatch;

class OrderDescripitionRepository implements OrderDescripitionRepositoryInterface{

    protected $bookDescription;

    public function __construct(
        OrderDescripition $bookDescription,
        CartRepository $cart
    ){
        $this->bookDescription = $bookDescription;
        $this->cart = $cart;
        
    }

    /**
     * Desciption : getModel -> get the model query  builder
     * 
     * @param : 
     * @return : 
     */ 

    public function getModel(){
        return $this->bookDescription; 
    }

    /**
     * Desciption : Create a new instance of the model OrderDetail 
     * 
     * @param : int $userId
     * @param : int $orderId
     * @return : 
     */ 
    public function create($userId,$orderId){
        $cartItemAllDetails = $this->cart->getCartItemAllDetails($userId);
        try{
            foreach($cartItemAllDetails as $cartItem){
                $this->getModel()->create([
                    'order_id' => $orderId,
                    'book_id' => $cartItem->book_id,
                    'book_quantity' => $cartItem->book_quantity,
                ]);
            }
            return true;
        }catch(Exception $e){
            Log::error(__METHOD__ . 'method : '.__LINE__ .'Line'. $e->getMessage. 'error -->while procecing order '.$orderId. 'of user'.$userId);
            return false;
        }
    }




}