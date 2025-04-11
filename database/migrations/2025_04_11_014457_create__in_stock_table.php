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
        Schema::create('_in_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employeeID')->constrained('employees')->onDelete('cascade'); 
            $table->foreignId('itemID')->constrained('items')->onDelete('cascade');
            $table->tinyInteger('status')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_in_stock');
    }
};
