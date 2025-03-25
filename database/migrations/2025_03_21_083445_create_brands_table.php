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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID
            $table->string('brand_name')->unique();  // Brand name with unique constraint
            $table->foreignId('categoryID')->constrained('categorytbl')->onDelete('cascade');  // Foreign key to categorytbl
            $table->timestamps();  // Created at & Updated at
     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
