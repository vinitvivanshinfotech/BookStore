<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// request
use App\Http\Requests\LoginRequest;

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
            Session::flash('error', 'Invalid Email or Password');
            return back();
        }
    }
}
