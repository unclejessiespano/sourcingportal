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
            if(!Schema::hasColumn('line_activities', 'icon_color')) {
                $table->renameColumn('icon-color', 'icon_color');
            }

            if(!Schema::hasColumn('line_activities', 'bg_color')) {
                $table->renameColumn('bg-color', 'bg_color');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
