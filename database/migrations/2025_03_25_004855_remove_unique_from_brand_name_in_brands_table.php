<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueFromBrandNameInBrandsTable extends Migration
{
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            // Drop the unique constraint from 'brand_name'
            $table->dropUnique(['brand_name']);
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            // Add the unique constraint back in case of rollback
            $table->unique('brand_name');
        });
    }
}
