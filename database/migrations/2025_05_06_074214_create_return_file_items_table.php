<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('return_file_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employeeID')->nullable();
            
            // Foreign key constraint
            $table->foreign('employeeID')
                  ->references('id')
                  ->on('employees')
                  ->onDelete('set null');
    
            $table->string('original_name');
            $table->string('storage_path');
            $table->string('mime_type');
            $table->integer('size');
            $table->timestamp('returned_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('return_file_items');
    }
};