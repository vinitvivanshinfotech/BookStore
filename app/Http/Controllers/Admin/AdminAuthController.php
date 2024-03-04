<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ForgetPasswordRequest;
use App\Models\PasswordResetToken;

// request
use App\Http\Requests\LoginRequest;
use App\Mail\ForgetPasswordLinkToAdmin;
use App\Models\Admin;

class AdminAuthController extends Controller
{



    public function showLoginForm()
    {
        return view('Auth.Admin.login');
    }

    public function adminLoginPost(LoginRequest $request)
    {
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('admin.dashboard');
        } else {
            return back()->with('error', 'Invalid Email or Password!');
        }
    }

    public function adminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.loginForm');
    }

    /**
     * Desciption : 
     *
     * @param :
     * @return : 
     */
    public function forgetpassword()
    {
        try {
            Log::info("Calling the foreget password form by admin");
            return view('Auth.Admin.forgetpassword');
        } catch (\Exception $e) {
            Log::error('Attempt to call  the view page of forget password by admin ', ['Error Message' => $e]);
            return response()->json(['error' => 'An error occurred while calling the forget passwor page .'], 500);
        }
    }

    /**
     * Desciption : 
     *
     * @param :
     * @return : 
     */
    public function submitForgetPasswordForm(ForgetPasswordRequest $request)
    {

        try {

            $data = $request->except('recover-submit');
            $data['token'] = Str::random(60);



            $token = $data['token'];
            $email = $data['email'];

            
            Mail::to($request->email)->send(new ForgetPasswordLinkToAdmin(['token' => $token], ['email' => $email]));

            PasswordResetToken::create($data);
            Log::info('sending the forget password link to admin succesfully ', ['Email' => $email]);
            return response()->json('Forget Password mail link was send to admin succesfully');
        } catch (\Exception $e) {
            Log::error('Attempt to send the forget password link to admin ', ['Error Message' => $e]);
            return response()->json(['error' => 'An error occurred while sending the forget password link to admin.'], 500);
        }
    }

    /**
    * Desciption : 
    *
    * @param :
    * @return : 
    */
    public function resetpasswordform()
    {
        return view('Auth.Admin.passwordresetmessage');
    }
    
    /**
    * Desciption : 
    *
    * @param :
    * @return : 
    */
    // ResetPasswordRequest
    public function submitResetPasswordForm(){

        return view('Auth.Admin.passwordresetform');
    }

    /**
    * Desciption : 
    *
    * @param :
    * @return : 
    */
    public function checktoken(Request $request){
        dd("okay");
    }
}
