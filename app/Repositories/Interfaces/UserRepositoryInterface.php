<?php

namespace App\Repositories\Interfaces;

// Models
use App\Models\User;

interface UserRepositoryInterface{

    /**
     * Desciption : getModel  Get user model query builder
     * 
     * @param : boolean $archived
     * @return : \Illuminate\Database\Eloquent\Builder
     */ 
    public function getModel();

    /**
     * Desciption : Create user 
     * 
     * @param : array $attributes
     * @return : \Illuminate\Database\Eloquent\Model 
     */ 
    public function create($attributes);

    /**
     * Desciption : update user 
     * 
     * @param : array $attributes
     * @return : \Illuminate\Database\Eloquent\Model 
     */ 
    public function update($attributes);

    /**
     * Desciption : find user by email
     * 
     * @param : string $email
     * @return : \Illuminate\Database\Eloquent\Model 
     */ 
    public function findUserByEmail($email);


}