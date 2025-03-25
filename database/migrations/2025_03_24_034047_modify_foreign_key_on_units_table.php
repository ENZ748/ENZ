<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyForeignKeyOnUnitsTable extends Migration
{
    public function up(): void
    {
        // Drop the existing foreign key constraint (if it exists)
        Schema::table('units', function (Blueprint $table) {
            $table->dropForeign(['brandID']);  // Drop the current foreign key on the 'brandID' column (if it exists)
        });

        // Add a new foreign key constraint referencing the 'id' column of the 'brands' table
        Schema::table('units', function (Blueprint $table) {
            $table->foreign('brandID') // The column in 'units' table
                ->references('id')     // The column it references in 'brands' table
                ->on('brands')         // The 'brands' table
                ->onDelete('cascade'); // On delete, cascade the change to 'units' table
        });
    }

    public function down(): void
    {
        // Drop the foreign key if we need to roll back
        Schema::table('units', function (Blueprint $table) {
            $table->dropForeign(['brandID']);
        });
    }
}
