<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use DB;

// Mail
use App\Mail\PasswordResetLinkToUserMail;

// request
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserPasswordResetRequest;
use App\Http\Requests\UpdatePasswordRequest;




// model
use App\Models\User;
use App\Models\PasswordResetToken;


// Interface
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

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
            Log::info('User created successfully with id: ' . $newUser->id);
            return redirect()->route('login')->with("Success", "Your account has been created successfully!");
        } catch (Exception $e) {
            log::error(__METHOD__ . " line " . __LINE__ . " Error while creating user account");
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
        try {
            Auth::guard('user')->logout();
            return redirect()->route('login');
        } catch (Exception $e) {
            Log::error(__METHOD__ . " line " . __LINE__ . " Error while logging out user" . auth()->user()->id);
        }
    }

    /**
     * Desciption : Return view file for reset password
     * 
     * @param : 
     * @return : 
     */
    public function forgotPasswordView()
    {
        return view('Auth.User.forgot-password');
    }

    /**
     * Desciption : Generate password reset token and send to user and save to database
     * 
     * @param : App\Http\Requests\UserPasswordResetRequest $request
     * @return : 
     */
    public function forgotPasswordPost(UserPasswordResetRequest $request)
    {
        try {
            DB::beginTransaction();
                $passwordResetToken = Str::random(64);
                $email = $request->email;

                $passwordResetTokenData = PasswordResetToken::create(
                    [
                        'email' => $email,
                        'token' => $passwordResetToken,
                        'role' => 'user',
                    ]
                )->toArray();

            Mail::to($email)->send(new PasswordResetLinkToUserMail(['token' => $passwordResetToken, 'email' => $email]));
            DB::commit();
            return redirect()->route('login')->with("Success", "Password reset link has been sent to your email!");
        } catch (Exception $e) {

            DB::rollback();
            Log::error(__METHOD__ . " line " . __LINE__ . " Error while sending password reset link to user of user with email " . $email);
            return redirect()->route('login')->with("error", "Error while sending password reset link.Please try again later");
        }
    }

    /**
     * Desciption : return view for  enter new password 
     * 
     * @param : Illuminate\Http\Request $request
     * @return : view
     */ 
    public function enterNewPasswordView(Request $request)
    {
        $email=$request->email;
        $token=$request->token;
        return view('Auth.User.enter-new-password-view',with(['email'=>$email, 'token'=>$token]));
    }

    /**
     * Desciption : 
     * 
     * @param : Illuminate\Http\Request $request
     * @return : 
     */ 
    public function updatePassword(UpdatePasswordRequest $request){
        $email = $request->email;
        $token = $request->passwordResetToken;
        $resetPaswordTokenData = PasswordResetToken::where('email', $email)->first();

    //     try{
    //         DB::transactio
    //     }
    }
}
