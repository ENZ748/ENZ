<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveNameFromUsersTable extends Migration
{
    public function up()
    {
        Schema::table('employee', function (Blueprint $table) {
            // Remove the 'name' column from the 'users' table
            $table->dropColumn('name');
        });
    }

    public function down()
    {
        // If you rollback this migration, add the 'name' column back
        Schema::table('users', function (Blueprint $table) {
            $table->string('name'); // Adding 'name' column back
        });
    }
}
