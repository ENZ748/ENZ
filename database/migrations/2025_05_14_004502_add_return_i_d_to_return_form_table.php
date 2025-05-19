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
        Schema::table('return_form', function (Blueprint $table) {
            // Add the new column (assuming it's a foreign key to item_history table)
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
        Schema::table('return_form', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['returnID']);
            // Then drop the column
            $table->dropColumn('returnID');
        });
    }
};