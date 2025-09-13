<?php

namespace App\Http\Controllers\admin;

use App\Helper\CatatLogAktivitas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public array $roles = ['Admin'];

    public function getIndex()
    {
        $menus = Menu::all();
        $params = ['menu' => $menus,];
        return view('admin.menu.index', $params);
    }

    public function getCreate(Request $request)
    {
        $menu = Menu::find($request->id);
        $parentMenus = Menu::whereNull('parent_id')->orderBy('order')->get();
        $params = ['menu' => $menu, 'parentMenus' => $parentMenus];
        return view('admin.menu.create', $params);
    }

    public function getDetail($id)
    {
        $menu = Menu::find($id);
        $parentMenus = Menu::whereNull('parent_id')->orderBy('order')->get();
        $params = ['menu' => $menu, 'parentMenus' => $parentMenus];
        return view('admin.menu.create', $params);
    }

    public function postStore(Request $request)
    {
        $id = $request->id;
        $menu = $id ? Menu::find($id) : new Menu;
        
        try {
            DB::beginTransaction();
            $menu->title = $request->title;
            $menu->url = $request->url;
            $menu->parent_id = $request->parent_id;
            $menu->order = $request->order;
            $menu->active = $request->has('active');
            $menu->save();
            DB::commit();
            
            if($id){
                sendTelegramMessage('Menu berhasil diupdate');
                CatatLogAktivitas::catatAktivitas('Menu berhasil diupdate');
                return successAlert('Menu berhasil diupdate', null, '', '/admin/menu');
            } else {
                sendTelegramMessage('Menu berhasil ditambahkan');
                CatatLogAktivitas::catatAktivitas('Menu berhasil ditambahkan');
                return successAlert('Menu berhasil ditambahkan', null, '', '/admin/menu');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return errorAlert('Menu gagal ' . ($id ? 'diupdate' : 'ditambahkan'), $th->getMessage());
        }
    }

    public function postDelete($id)
    {
        $menu = Menu::find($id);
        
        if ($menu->children()->count() > 0) {
            return errorAlert('Menu ini memiliki sub-menu. Hapus sub-menu terlebih dahulu.');
        }
        
        try {
            DB::beginTransaction();
            $menu->delete();
            DB::commit();
            sendTelegramMessage('Menu berhasil dihapus');
            CatatLogAktivitas::catatAktivitas('Menu berhasil dihapus');
            return successAlert('Menu berhasil dihapus', null, '', '/admin/menu');
        } catch (\Throwable $th) {
            DB::rollBack();
            return errorAlert('Menu gagal dihapus', $th->getMessage());
        }
    }
    
    public function postUpdate(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $menu = Menu::findOrFail($id);
            $data = [
                'title' => $request->title,
                'url' => $request->url,
                'parent_id' => $request->parent_id,
                'order' => $request->order,
                'active' => $request->has('active'),
            ];

            $menu->update($data);

            DB::commit();
            return successAlert('Menu berhasil diupdate', null, '', '/admin/menu');

        } catch (\Exception $e) {
            DB::rollBack();
            return errorAlert('Terjadi kesalahan saat mengupdate menu: ' . $e->getMessage());
        }
    }
    
    public function postToggleStatus($id)
    {
        $menu = Menu::find($id);
        
        try {
            DB::beginTransaction();
            $menu->active = !$menu->active;
            $menu->save();
            DB::commit();
            
            $status = $menu->active ? 'diaktifkan' : 'dinonaktifkan';
            sendTelegramMessage('Menu berhasil ' . $status);
            CatatLogAktivitas::catatAktivitas('Menu berhasil ' . $status);
            return successAlert('Menu berhasil ' . $status);
        } catch (\Throwable $th) {
            DB::rollBack();
            return errorAlert('Menu gagal diupdate', $th->getMessage());
        }
    }
}
