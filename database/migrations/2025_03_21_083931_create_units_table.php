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
        Schema::create('units', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID
            $table->string('unit_name')->unique();  // Unit name with unique constraint
            $table->foreignId('brandID')->constrained('brandtbl')->onDelete('cascade');  // Foreign key to categorytbl
            $table->timestamps();  // Created at & Updated at
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
