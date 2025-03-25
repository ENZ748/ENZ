<?php
// database/migrations/xxxx_xx_xx_create_brandtbl_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandtblTable extends Migration
{
    public function up()
    {
        Schema::create('brandtbl', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID
            $table->string('brand_name')->unique();  // Brand name with unique constraint
            $table->foreignId('categoryID')->constrained('categorytbl')->onDelete('cascade');  // Foreign key to categorytbl
            $table->timestamps();  // Created at & Updated at
        });
    }

    public function down()
    {
        Schema::dropIfExists('brandtbl');
    }
}
