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
        Schema::create('line_activities', function (Blueprint $table) {
            $table->id();
            $table->string('activity');
            $table->string('slug')->unique();
            $table->string('icon');
            $table->string('icon_color');
            $table->string('bg_color');
            $table->string('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_activities');
    }
};
