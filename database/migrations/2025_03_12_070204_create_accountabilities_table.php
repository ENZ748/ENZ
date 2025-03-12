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
        Schema::create('accountabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->unsignedBigInteger('equipment_id');
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
            $table->date('assigned_date');
            $table->date('return_date');
            $table->text('notes');
            $table->enum('assigned_by', ['IT','HR']);
            $table->timestamps();
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accountabilities');
    }
};
