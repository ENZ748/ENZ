<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemStatusToAssignedItemsTable extends Migration
{
    public function up(): void
    {
        Schema::table('assigned_items', function (Blueprint $table) {
            // Add item_status column with enum type
            $table->enum('item_status', ['returned', 'unreturned'])->default('unreturned');
        });
    }

    public function down(): void
    {
        Schema::table('assigned_items', function (Blueprint $table) {
            // Remove item_status column if rolling back
            $table->dropColumn('item_status');
        });
    }
}
