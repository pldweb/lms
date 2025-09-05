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
        $menus = Menu::whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();

        $params = [
            'menu' => $menus,
        ];
        return view('admin.menu.index', $params);
    }

    public function getCreate()
    {
        $parentMenus = Menu::whereNull('parent_id')->orderBy('order')->get();
        return view('admin.menu.create', compact('parentMenus'));
    }

    public function postStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Menu::create([
            'title' => $request->title,
            'url' => $request->url,
            'icon' => $request->icon,
            'parent_id' => $request->parent_id,
            'order' => $request->order,
            'active' => $request->has('active'),
        ]);

        return redirect('/admin/menu')->with('success', 'Menu berhasil ditambahkan');
    }

    public function getEdit(string $id)
    {
        $menu = Menu::findOrFail($id);
        $parentMenus = Menu::whereNull('parent_id')
            ->where('id', '!=', $id)
            ->orderBy('order')
            ->get();

        return view('admin.menu.edit', compact('menu', 'parentMenus'));
    }

    public function postUpdate(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $menu = Menu::findOrFail($id);

        // Prevent setting itself as parent
        if ($request->parent_id == $id) {
            return redirect()->back()
                ->with('error', 'Menu tidak dapat menjadi parent dari dirinya sendiri')
                ->withInput();
        }

        $menu->update([
            'title' => $request->title,
            'url' => $request->url,
            'icon' => $request->icon,
            'parent_id' => $request->parent_id,
            'order' => $request->order,
            'active' => $request->has('active'),
        ]);

        return redirect('/admin/menu')->with('success', 'Menu berhasil diperbarui');
    }

    public function getDelete(string $id)
    {
        $menu = Menu::findOrFail($id);
        
        // Check if menu has children
        if ($menu->children()->count() > 0) {
            return redirect()->back()->with('error', 'Menu ini memiliki sub-menu. Hapus sub-menu terlebih dahulu.');
        }
        
        $menu->delete();
        
        return redirect('/admin/menu')->with('success', 'Menu berhasil dihapus');
    }
    
    public function postUpdateOrder(Request $request)
    {
        $menuItems = $request->input('menu', []);
        
        foreach ($menuItems as $index => $item) {
            $menuId = $item['id'];
            $parentId = isset($item['parent_id']) ? $item['parent_id'] : null;
            
            $menu = Menu::findOrFail($menuId);
            $menu->update([
                'parent_id' => $parentId,
                'order' => $index
            ]);
        }
        
        return response()->json(['success' => true]);
    }
}
