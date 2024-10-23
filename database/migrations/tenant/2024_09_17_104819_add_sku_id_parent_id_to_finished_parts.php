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
        Schema::table('finished_parts', function (Blueprint $table) {
            $table->integer('sku_id')->after('id')->nullable();
            $table->integer('parent_id')->after('sku_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('finished_parts', function (Blueprint $table) {
            //
        });
    }
};
