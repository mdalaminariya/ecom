<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{

    //Login function start
    public function login(){
        return view('auth.login');
    }

    //Login function end

    //Register function start
    public function register(){
        return view('auth.register');
    }

    //Register function end
}
