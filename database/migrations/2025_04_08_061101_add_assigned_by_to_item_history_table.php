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
        Schema::table('item_history', function (Blueprint $table) {
            $table->string('assigned_by')->nullable(); // Adds the assigned_by column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_history', function (Blueprint $table) {
            $table->dropColumn('assigned_by'); // Removes the assigned_by column
        });
    }
};
