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
        Schema::table('agendaitems', function (Blueprint $table) {
            if(!Schema::hasColumn('agendaitems', 'identifier')) {
                $table->string('identifier')->after('assigned_to');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendaitems', function (Blueprint $table) {
            //
        });
    }
};
