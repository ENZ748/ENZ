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
        Schema::create('return_form', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_formID')->constrained('asset_form')->onDelete('cascade'); 
            $table->string('issuance_number'); 
            $table->timestamps();
            $table->foreignId('returnID')
            ->nullable() // if you want it to be optional
            ->constrained('item_history') // assuming it references item_history table
            ->onDelete('cascade'); // or set null, restrict etc. as needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_form');
    }
};