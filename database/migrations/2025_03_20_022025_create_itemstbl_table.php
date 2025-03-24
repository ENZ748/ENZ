<?php
// database/migrations/xxxx_xx_xx_create_itemstbl_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemstblTable extends Migration
{
    public function up()
    {
        Schema::create('itemstbl', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID
            $table->foreignId('categoryID')->constrained('categorytbl')->onDelete('cascade');  // Foreign key to categorytbl
            $table->foreignId('brandID')->constrained('brandtbl')->onDelete('cascade');  // Foreign key to brandtbl
            $table->foreignId('unitID')->constrained('unittbl')->onDelete('cascade');  // Foreign key to unittbl
            $table->string('serial_number')->unique();  // Unique serial number
            $table->integer('equipment_status')->deafault(0);  // Equipment status (e.g., new, used, etc.)
            $table->date('date_purchased');  // Date purchased
            $table->date('date_acquired');  // Date acquired
            $table->timestamps();  // Created at & Updated at
        });
    }

    public function down()  
    {
        Schema::dropIfExists('itemstbl');
    }
}
