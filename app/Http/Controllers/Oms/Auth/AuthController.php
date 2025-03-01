<?php

namespace App\Http\Controllers\Oms\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
        if($request->method() == "GET"){
            return view("oms.auth.login");
        }
    }

    public function forgetPassword(Request $request){
        if($request->method() == "GET"){
            return view("oms.auth.forget_password");
        }
    }
}
