<?php

namespace App\Http\Controllers\auth;

use \App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class LogoutController extends Controller
{
    public function postLogoutAction(Request $request){
        Auth::logout();
        return redirect('/');
    }
}
