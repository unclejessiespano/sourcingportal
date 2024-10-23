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
        Schema::table('touchpoints', function (Blueprint $table) {
            if(!Schema::hasColumn('touchpoints', 'code')) {
                $table->char('code', 6)->after('id')->unique();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('touchpoints', function (Blueprint $table) {
            //
        });
    }
};
