<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('item_history', function (Blueprint $table) {
            // Add the new fileID column after itemID
            $table->foreignId('fileID')
                  ->after('itemID')
                  ->nullable()
                  ->constrained('return_signed_items')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('item_history', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['fileID']);
            // Then drop the column
            $table->dropColumn('fileID');
        });
    }
};