<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class UserController extends Controller
{
    public array $roles = ['Admin', 'Guru', 'Siswa'];

    public function getAdmin()
    {
        $users = User::role(['Admin'])->get();
        $params = [
            'users' => $users,
            'jenis' => 'admin'
        ];
        return view('admin.user.admin', $params);
    }

    public function getGuru()
    {
        $users = User::role(['Guru'])->get();
        $params = [
            'users' => $users,
            'jenis' => 'guru'
        ];
        return view('admin.user.admin', $params);
    }

    public function getSiswa()
    {
        $users = User::role(['Siswa'])->get();
        $params = [
            'users' => $users,
            'jenis' => 'siswa'
        ];
        return view('admin.user.admin', $params);
    }

}
