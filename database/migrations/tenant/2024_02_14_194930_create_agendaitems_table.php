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
        Schema::create('agendaitems', function (Blueprint $table) {
            $table->id();
            $table->integer('meeting_id');
            $table->integer('assigned_to');
            $table->enum('complete', array('y','n'))->default('n');
            $table->string('item');
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendaitems');
    }
};
