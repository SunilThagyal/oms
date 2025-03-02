<?php

namespace App\Http\Controllers\Oms\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('oms.auth.login');
        }

        if ($request->isMethod('post')) {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
            $remember = $request->has('remember'); // Check for "remember me" option

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
                $user = Auth::user();
                if (!$user->hasRole('store')) {
                    Auth::logout();
                    return back()->withErrors(['email' => 'Access denied. Only store users can log in.']);
                }
                return redirect()->route('oms.dashboard')->with('success', 'Logged in successfully.');
            }

            return back()->withErrors(['error' => 'Invalid credentials.'])->withInput();
        }

    }

    public function forgetPassword(Request $request){
        if($request->method() == "GET"){
            return view("oms.auth.forget_password");
        }
    }

    public function logout(){
        Auth()->logout();
        return redirect("login");
    }
}
