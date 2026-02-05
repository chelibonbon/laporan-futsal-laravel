<?php

if (!function_exists('getUserRolePrefix')) {
    /**
     * Get user role prefix for routing
     *
     * @return string
     */
    function getUserRolePrefix()
    {
        if (!Auth::check()) {
            return 'customer';
        }
        
        return match(Auth::user()->role) {
            'superadmin' => 'superadmin',
            'admin' => 'admin',
            'manager' => 'manager',
            'customer' => 'customer',
            default => 'customer',
        };
    }
}

if (!function_exists('formatRupiah')) {
    /**
     * Format number to Rupiah
     *
     * @param float $amount
     * @return string
     */
    function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('getStatusBadge')) {
    /**
     * Get status badge HTML
     *
     * @param string $status
     * @return string
     */
    function getStatusBadge($status)
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'confirmed' => '<span class="badge bg-success">Confirmed</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>',
            'completed' => '<span class="badge bg-info">Completed</span>',
            'cancelled' => '<span class="badge bg-secondary">Cancelled</span>',
            'aktif' => '<span class="badge bg-success">Aktif</span>',
            'tidak_aktif' => '<span class="badge bg-danger">Tidak Aktif</span>',
            'verified' => '<span class="badge bg-success">Verified</span>',
        ];
        
        return $badges[$status] ?? '<span class="badge bg-secondary">' . ucfirst($status) . '</span>';
    }
}

if (!function_exists('hasMenuAccess')) {
    /**
     * Check if user has access to specific menu
     *
     * @param string $menuKey
     * @return bool
     */
    function hasMenuAccess($menuKey)
    {
        if (!Auth::check()) {
            return false;
        }
        
        // Use exact role names from database
        $userRole = Auth::user()->role;
        
        // Safety check: SuperAdmin should always have access to hak akses page
        // to prevent being locked out
        if ($userRole === 'superadmin' && $menuKey === 'hakakses') {
            return true;
        }
        
        // Check menu access from database
        $access = \App\Models\MenuAccess::where('role', $userRole)
            ->where('menu_name', $menuKey)
            ->first();
            
        return $access ? $access->can_access : false;
    }
}
