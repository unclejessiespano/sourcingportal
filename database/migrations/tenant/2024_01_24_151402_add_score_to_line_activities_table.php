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
        Schema::table('line_activities', function (Blueprint $table) {
            if(!Schema::hasColumn('line_activities', 'score')) {
                $table->integer('score')->after('value')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('line_activities', function (Blueprint $table) {
            //
        });
    }
};
