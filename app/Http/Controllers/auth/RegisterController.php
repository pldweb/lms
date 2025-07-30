<?php

namespace App\Http\Controllers\auth;

use \App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function getIndex(){
        return view('landing.auth.login');
    }
}
