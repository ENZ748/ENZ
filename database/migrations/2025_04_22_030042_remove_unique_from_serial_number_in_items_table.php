<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueFromSerialNumberInItemsTable extends Migration
{
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            // Remove the unique index from the 'serial_number' column
            $table->dropUnique(['serial_number']);
        });
    }

    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            // Add the unique index back if you rollback the migration
            $table->unique('serial_number');
        });
    }
}
