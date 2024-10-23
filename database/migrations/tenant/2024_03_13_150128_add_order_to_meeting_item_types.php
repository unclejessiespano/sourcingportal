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
        Schema::table('meeting_item_types', function (Blueprint $table) {
            if(!Schema::hasColumn('meeting_item_types', 'order')) {
                $table->integer('order')->after('id')->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meeting_item_types', function (Blueprint $table) {
            //
        });
    }
};
