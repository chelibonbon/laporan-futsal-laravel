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
        Schema::create('custom_menus', function (Blueprint $table) {
            $table->id();
            $table->string('menu_key')->unique(); // Unique key for menu identification
            $table->string('menu_name'); // Display name
            $table->text('description')->nullable(); // Menu description
            $table->string('icon')->nullable(); // Icon class (optional)
            $table->string('route')->nullable(); // Route name (optional)
            $table->string('url')->nullable(); // URL (optional)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_menus');
    }
};
