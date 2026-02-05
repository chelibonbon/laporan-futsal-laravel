<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu_accesses', function (Blueprint $table) {
            $table->id();
            $table->string('role'); // admin, leader_kasir, kasir, manajer
            $table->string('menu_name'); // dashboard, pos, gudang_lihat, gudang_kelola, etc
            $table->boolean('can_access')->default(false);
            $table->timestamps();
            
            $table->unique(['role', 'menu_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_accesses');
    }
};
