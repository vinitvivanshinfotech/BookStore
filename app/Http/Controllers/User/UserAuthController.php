<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

// request
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;


// model
use App\Models\User;


// Interface
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserAuthController extends Controller
{
    public function __construct(
        UserRepositoryInterface $user
    ) {
        $this->user = $user;
    }

    public function showRegisterForm()
    {
        return view('Auth.User.register');
    }

    public function showLoginForm()
    {
        return view('Auth.User.login');
    }

    public function userRegistrationPost(RegisterRequest $request)
    {
        try {
            $attributes = $request->except(['_token', 'password_confirmation']);
            $newUser = $this->user->getModel()->create($attributes);
            Log::info('User created successfully with id: ' .$newUser->id);
            return redirect()->route('login')->with("Success", "Your account has been created successfully!");
        } catch (Exception $e) {
            log::error(__METHOD__." line ".__LINE__." Error while creating user account");
        };
    }

    public function userLoginPost(LoginRequest $request)
    {
        if (Auth::guard('user')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            // Authentication passed...
            Session::flash("success", "You are Successfully Logged In!");
            return redirect()->route('user.dashboard')->with(["Success" => "You are Logged In Successfully"]);
        } else {
            Session::flash('error', 'Invalid Email or Password!');
            return  redirect()->back();
        }
    }

    /**
     * Desciption : 
     * 
     * @param : 
     * @return : 
     */
    public function userLogout()
    {
        try{
            Auth::guard('user')->logout();
            return redirect()->route('login'); 
        }catch(Exception $e){
            Log::error(__METHOD__." line ".__LINE__." Error while logging out user". auth()->user()->id);
        }
    }
}
