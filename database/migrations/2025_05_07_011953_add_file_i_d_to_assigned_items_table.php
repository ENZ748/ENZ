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
        Schema::table('assigned_items', function (Blueprint $table) {
              // Add the new fileID column after itemID
              $table->foreignId('fileID')
              ->after('itemID')
              ->nullable()
              ->constrained('return_signed_items')
              ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assigned_items', function (Blueprint $table) {
             // Drop the foreign key constraint first
             $table->dropForeign(['fileID']);
             // Then drop the column
             $table->dropColumn('fileID');
        });
    }
};
