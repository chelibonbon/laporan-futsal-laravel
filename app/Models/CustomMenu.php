<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_key',
        'menu_name',
        'description',
        'icon',
        'route',
        'url',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function menuAccesses()
    {
        return $this->hasMany(MenuAccess::class, 'menu_name', 'menu_key');
    }

    public function getAccessForRole($role)
    {
        return $this->menuAccesses()->where('role', $role)->first();
    }
}
