<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;   

class DashboardController extends Controller
{

    public array $roles = ['Admin', 'Guru'];

    public function getIndex(){
        return view('admin.dashboard');
    }
}
