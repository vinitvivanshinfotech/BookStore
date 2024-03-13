<?php

namespace App\Repositories;

// Models
use App\Models\User;

// Interface
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface{

    protected $user;

    public function __construct(
        User $user,
    ){
        $this->user = $user;
    }

    /**
     * Desciption : getModel -> get the model query  builder
     * 
     * @param : 
     * @return : 
     */ 

    public function getModel(){
        return $this->user; 
    }

    /**
     * Desciption : Create user 
     * 
     * @param : array $attributes
     * @return : \Illuminate\Database\Eloquent\Model 
     */ 
    public function create($attributes){
        return $this->getModel()->create($attributes);
    }


    /**
     * Desciption : update user 
     * 
     * @param : array $attributes
     * @return : \Illuminate\Database\Eloquent\Model 
     */ 
    public function update($attributes){
        return $this->getModel()->where('id',$attributes['id'])->update($attributes);
    }

    /**
     * Desciption : find user by email
     * 
     * @param : string $email
     * @return : \Illuminate\Database\Eloquent\Model 
     */ 
    public function findUserByEmail($email){
        return $this->getModel()->where('email',$email)->first();
    }



}