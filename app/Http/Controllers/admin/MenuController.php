<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public array $roles = ['Admin'];

    public function getIndex()
    {
        $menus = Menu::all();
        $params = ['menu' => $menus,];
        return view('admin.menu.index', $params);
    }

    public function getCreate()
    {
        $parentMenus = Menu::whereNull('parent_id')->orderBy('order')->get();
        $params = ['parentMenus' => $parentMenus];
        return view('admin.menu.create', $params);
    }

    public function getDetail($id)
    {
        $menu = Menu::findOrFail($id);
        $params = ['menu' => $menu];
        return view('admin.menu.edit', $params);
    }

    public function postStore(Request $request)
    {
        try {
            DB::beginTransaction();

             Menu::create([
            'title' => $request->title,
            'url' => $request->url,
            'icon' => $request->icon,
            'parent_id' => $request->parent_id,
            'order' => $request->order,
            'active' => $request->has('active'),
        ]);

        $redirect = '/admin/menu';
        DB::commit();
        return successAlert('Menu berhasil ditambahkan', null, '', $redirect);
        } catch (\Throwable $th) {
            DB::rollBack();
            return errorAlert('Menu gagal ditambahkan', $th->getMessage());
        }
    }

    public function postDelete($id)
    {
        $menu = Menu::findOrFail($id);
        
        if ($menu->children()->count() > 0) {
            return redirect()->back()->with('error', 'Menu ini memiliki sub-menu. Hapus sub-menu terlebih dahulu.');
        }
        $menu->delete();
        return successAlert('Menu berhasil dihapus', null, '', '/admin/menu');
    }
}
