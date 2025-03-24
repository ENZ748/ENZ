<?php
// database/migrations/xxxx_xx_xx_create_categorytbl_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorytblTable extends Migration
{
    public function up()
    {
        Schema::create('categorytbl', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID
            $table->string('category_name')->unique();  // Category name with unique constraint
            $table->timestamps();  // Created at & Updated at
        });
    }

    public function down()
    {
        Schema::dropIfExists('categorytbl');
    }
}
