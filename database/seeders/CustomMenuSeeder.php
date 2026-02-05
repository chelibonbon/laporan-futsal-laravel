<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomMenuSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing menus
        DB::table('custom_menus')->delete();
        
        $menus = [
            [
                'menu_key' => 'dashboard',
                'menu_name' => 'Dashboard',
                'description' => 'Halaman utama dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'route' => 'dashboard',
                'url' => '/dashboard',
                'is_active' => true,
            ],
            [
                'menu_key' => 'bookings',
                'menu_name' => 'Bookings',
                'description' => 'Manajemen booking lapangan',
                'icon' => 'fas fa-calendar',
                'route' => 'bookings.index',
                'url' => '/bookings',
                'is_active' => true,
            ],
            [
                'menu_key' => 'lapangans',
                'menu_name' => 'Lapangans',
                'description' => 'Manajemen lapangan futsal',
                'icon' => 'fas fa-map',
                'route' => 'lapangans.index',
                'url' => '/lapangans',
                'is_active' => true,
            ],
            [
                'menu_key' => 'users',
                'menu_name' => 'Kelola User',
                'description' => 'Manajemen pengguna sistem',
                'icon' => 'fas fa-users',
                'route' => 'users.index',
                'url' => '/users',
                'is_active' => true,
            ],
            [
                'menu_key' => 'keuangan',
                'menu_name' => 'Keuangan',
                'description' => 'Laporan keuangan dan pembayaran',
                'icon' => 'fas fa-money-bill-wave',
                'route' => 'keuangan.index',
                'url' => '/keuangan',
                'is_active' => true,
            ],
            [
                'menu_key' => 'settings',
                'menu_name' => 'Web Setting',
                'description' => 'Pengaturan sistem',
                'icon' => 'fas fa-cog',
                'route' => 'settings.index',
                'url' => '/settings',
                'is_active' => true,
            ],
            [
                'menu_key' => 'hakakses',
                'menu_name' => 'Hak Akses',
                'description' => 'Manajemen hak akses menu',
                'icon' => 'fas fa-user-shield',
                'route' => 'hakakses.index',
                'url' => '/hakakses',
                'is_active' => true,
            ],
            [
                'menu_key' => 'activities',
                'menu_name' => 'Log Activity',
                'description' => 'Log aktivitas sistem',
                'icon' => 'fas fa-history',
                'route' => 'activities.index',
                'url' => '/activities',
                'is_active' => true,
            ],
        ];

        DB::table('custom_menus')->insert($menus);
        
        // Create default access permissions
        $this->createDefaultAccess();
    }
    
    private function createDefaultAccess(): void
    {
        // Clear existing access
        DB::table('menu_accesses')->delete();
        
        $roles = ['superadmin', 'admin', 'manager', 'customer'];
        $menus = ['dashboard', 'bookings', 'lapangans', 'users', 'keuangan', 'settings', 'hakakses', 'activities'];
        
        // Default permissions based on current system logic
        $defaultPermissions = [
            'superadmin' => [
                'dashboard' => true,
                'bookings' => true,
                'lapangans' => true,
                'users' => true,
                'keuangan' => true,
                'settings' => true,
                'hakakses' => true,
                'activities' => true,
            ],
            'admin' => [
                'dashboard' => true,
                'bookings' => true,
                'lapangans' => true,
                'users' => true,
                'keuangan' => true,
                'settings' => false,
                'hakakses' => false,
                'activities' => true,
            ],
            'manager' => [
                'dashboard' => true,
                'bookings' => true,
                'lapangans' => true,
                'users' => false,
                'keuangan' => true,
                'settings' => false,
                'hakakses' => false,
                'activities' => true,
            ],
            'customer' => [
                'dashboard' => true,
                'bookings' => true,
                'lapangans' => true,
                'users' => false,
                'keuangan' => false,
                'settings' => false,
                'hakakses' => false,
                'activities' => true,
            ],
        ];
        
        foreach ($roles as $role) {
            foreach ($menus as $menu) {
                DB::table('menu_accesses')->insert([
                    'role' => $role,
                    'menu_name' => $menu,
                    'can_access' => $defaultPermissions[$role][$menu] ?? false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
