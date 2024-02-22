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

class UserAuthController extends Controller
{
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
        $user = User::create([
            'first_name'=>$request->input('first_name'),
            'last_name'=>$request->input('last_name'),
            'email'=>$request->input('email'),
            'phone_number'=>$request->input('phone_number'),
            'password'=>$request->input('password'),
        ]);
        
        return redirect()->route('login')->with("Success","Your account has been created successfully!");
    }

    public function userLoginPost(LoginRequest $request){
        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))  
        {  
            // Authentication passed...
            Session::flash( "success", "You are Successfully Logged In!" ); 
            return redirect()->route('user.dashboard')->with(["Success"=>"You are Logged In Successfully","user"=>Auth::user()]); 
        }  
        else    
        {  
            Session::flash( 'error', 'Invalid Email or Password!' ); 
            return  redirect() ->back();
        }
    }

    /**
     * Desciption : 
     * 
     * @param : 
     * @return : 
     */ 
    public function userLogout(){
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
}
