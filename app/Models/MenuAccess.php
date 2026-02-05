<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
        'menu_name',
        'can_access'
    ];

    protected $casts = [
        'can_access' => 'boolean'
    ];

    public function customMenu()
    {
        return $this->belongsTo(CustomMenu::class, 'menu_name', 'menu_key');
    }
}
