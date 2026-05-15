<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cafe_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->enum('category', ['makanan', 'minuman', 'snack']);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { 
        Schema::dropIfExists('menus'); 
    }
};
