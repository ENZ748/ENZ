<?php
// database/migrations/xxxx_xx_xx_create_unittbl_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnittblTable extends Migration
{
    public function up()
    {
        Schema::create('unittbl', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID
            $table->string('unit_name')->unique();  // Unit name with unique constraint
            $table->foreignId('brandID')->constrained('brandtbl')->onDelete('cascade');  // Foreign key to categorytbl
            $table->timestamps();  // Created at & Updated at
        });
    }

    public function down()
    {
        Schema::dropIfExists('unittbl');
    }
}
