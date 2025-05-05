<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('uploaded_files', function (Blueprint $table) {
            // First create the column (assuming employees table exists)
            $table->unsignedBigInteger('employeeID')->nullable();
            
            // Then add the foreign key constraint
            $table->foreign('employeeID')
                  ->references('id')
                  ->on('employees')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('uploaded_files', function (Blueprint $table) {
            $table->dropForeign(['employeeID']);
            $table->dropColumn('employeeID');
        });
    }
};