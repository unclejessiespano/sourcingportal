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
        Schema::table('lines', function (Blueprint $table) {
            if(!Schema::hasColumn('lines', 'active')) {
                $table->enum('active', array('y','n'))->after('id')->default('n');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lines', function (Blueprint $table) {
            //
        });
    }
};
