<?php

namespace App\Http\Controllers\auth;

use \App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function getIndex(){
        return view('landing.auth.login');
    }

    public function postLoginAction(Request $request){

       $credentials = $request->only('email', 'password');

       if (Auth::attempt($credentials)) {
            $redirectURL = url('/admin/dashboard');
            return successAlert('Berhasil Login', null, '', $redirectURL);
       }
       return errorAlert('Email atau Password Salah', null, '', null);
    }
}
