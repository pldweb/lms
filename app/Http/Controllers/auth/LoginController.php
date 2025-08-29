<?php

namespace App\Http\Controllers\auth;

use \App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function getIndex(){
        return view('landing.auth.login');
    }

    public function postLoginAction(Request $request){

       $credentials = $request->only('email', 'password');

       try {
            $user = User::where('email', $credentials['email'])->first();
            if (!$user) {
                return errorAlert('Email atau Password Salah', null, '', null);
            }
            if (!Hash::check($credentials['password'], $user->password)) {
                return errorAlert('Email atau Password Salah', null, '', null);
            }
            Auth::login($user);
            $redirectURL = url('/admin/dashboard');
            $nama = Auth::user()->nama;
            sendTelegramMessage("User $nama berhasil login");
            return successAlert('Berhasil Login', null, '', $redirectURL);
       } catch (\Throwable $th) {
            return errorAlert('Email atau Password Salah', null, '', null);
       }
    }
}
