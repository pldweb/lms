<?php

namespace App\Http\Controllers\auth;

use \App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function getIndex(){
        return view('landing.auth.register');
    }

    public function postRegisterAction(Request $request){

       $credentials = $request->only('nama', 'email', 'password', 'confirmation-password');

       if($credentials['password'] != $credentials['confirmation-password']){
            return errorAlert('Password dan Konfirmasi Password Tidak Sama', null, '', null);
       }

       if(strlen($credentials['password']) < 8){
            return errorAlert('Password minimal 8 karakter', null, '', null);
       }

       if(!preg_match('/[A-Z]/', $credentials['password'])){
            return errorAlert('Password harus memiliki minimal 1 huruf kapital', null, '', null);
       }

       try {
            DB::beginTransaction();
            $user = User::create([
                'nama' => $credentials['nama'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password']),
            ]);
            $user->assignRole('Admin');
            DB::commit();
            sendTelegramMessage("User $credentials[nama] berhasil register");
            return successAlert('Berhasil Register, silahkan login untuk melanjutkan', null, '', '/auth/login');
       } catch (\Throwable $th) {
            DB::rollBack();
            return errorAlert('Gagal Register', null, '', null);
       }
    }
}
