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
            $table->string('name')->after('parent_id')->nullable()->change();
            $table->longText('description')->after('name')->nullable()->change();
            $table->string('image')->after('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nullablle_finished_parts', function (Blueprint $table) {
            //
        });
    }
};
