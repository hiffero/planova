<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Tambahkan kolom notes jika belum ada
            if (!Schema::hasColumn('reservations', 'notes')) {
                $table->text('notes')->nullable()->after('guests');
            }
            
            // Tambahkan kolom selected_menus jika belum ada (untuk fitur pilih menu)
            if (!Schema::hasColumn('reservations', 'selected_menus')) {
                $table->json('selected_menus')->nullable()->after('notes');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['notes', 'selected_menus']);
        });
    }
};