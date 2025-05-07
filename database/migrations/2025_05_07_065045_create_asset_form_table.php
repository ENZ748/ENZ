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
        Schema::create('asset_form', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employeeID')->constrained('employees')->onDelete('cascade'); 
            $table->foreignId('assignedID')->constrained('assigned_items')->onDelete('cascade');
            $table->string('issuance_number'); 
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::table('asset_form', function (Blueprint $table) {
            $table->dropUnique(['issuance_number']); 
        });
        
        Schema::dropIfExists('asset_form');
    }
};