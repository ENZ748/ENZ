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
        Schema::table('return_items', function (Blueprint $table) {
            $table->enum('assigned_by', ['IT','HR'])->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('return_items', function (Blueprint $table) {
            $table->dropColumn('assigned_by');

        });
    }
};
