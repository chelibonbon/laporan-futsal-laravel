<?php

namespace App\Http\Controllers;

use App\Models\CustomMenu;
use App\Models\MenuAccess;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuAccessController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403);
        }

        // Get all menus
        $menus = CustomMenu::where('is_active', true)->orderBy('menu_name')->get();

        // Define roles based on actual system roles
        $roles = ['superadmin', 'admin', 'manager', 'customer'];

        // Get current access for all roles and menus
        $accessData = [];
        foreach ($roles as $role) {
            foreach ($menus as $menu) {
                $access = MenuAccess::where('role', $role)
                    ->where('menu_name', $menu->menu_key)
                    ->first();
                
                $accessData[$role][$menu->menu_key] = $access ? $access->can_access : false;
            }
        }

        return view('hakakses.index', compact('menus', 'roles', 'accessData'));
    }

    public function update(Request $request)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403);
        }

        $request->validate([
            'access' => 'required|array',
            'access.*.*' => 'nullable|boolean',
        ]);

        $roles = ['superadmin', 'admin', 'manager', 'customer'];
        
        foreach ($roles as $role) {
            foreach ($request->access as $menuKey => $accesses) {
                if (array_key_exists($role, $accesses)) {
                    MenuAccess::updateOrCreate(
                        [
                            'role' => $role,
                            'menu_name' => $menuKey
                        ],
                        [
                            'can_access' => $accesses[$role] ?? false
                        ]
                    );
                }
            }
        }

        // Log activity
        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'menu_access_updated',
            'description' => 'Memperbarui hak akses menu',
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Hak akses menu berhasil diperbarui');
    }
}
