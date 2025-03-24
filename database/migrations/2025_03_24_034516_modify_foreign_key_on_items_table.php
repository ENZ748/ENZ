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
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['categoryID']);  
            $table->dropForeign(['brandID']);  
            $table->dropForeign(['unitID']);  

        });

        Schema::table('items', function (Blueprint $table) {
            $table->foreign('categoryID') // The column in 'units' table
                ->references('id')     // The column it references in 'brands' table
                ->on('categories')         // The 'brands' table
                ->onDelete('cascade'); // On delete, cascade the change to 'units' table

            $table->foreign('brandID') // The column in 'units' table
                ->references('id')     // The column it references in 'brands' table
                ->on('brands')         // The 'brands' table
                ->onDelete('cascade'); // On delete, cascade the change to 'units' table

            $table->foreign('unitID') // The column in 'units' table
                ->references('id')     // The column it references in 'brands' table
                ->on('units')         // The 'brands' table
                ->onDelete('cascade'); // On delete, cascade the change to 'units' table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {

            $table->dropForeign(['categoryID']);
            $table->dropForeign(['brandID']);
            $table->dropForeign(['unitID']);

        });
    }
};
