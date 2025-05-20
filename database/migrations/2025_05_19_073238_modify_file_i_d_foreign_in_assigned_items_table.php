<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assigned_items', function (Blueprint $table) {
            // Drop the old foreign key first
            $table->dropForeign(['fileID']);
            
            // Then add the correct foreign key reference
            $table->foreign('fileID')
                  ->references('id')
                  ->on('assets_signed_items')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('assigned_items', function (Blueprint $table) {
            $table->dropForeign(['fileID']);

            $table->foreign('fileID')
                  ->references('id')
                  ->on('return_signed_items')
                  ->onDelete('set null');
        });
    }
};
