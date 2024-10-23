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
        Schema::create('meeting_items', function (Blueprint $table) {
            $table->id();
            $table->enum('complete', array('y','n'))->default('n');
            $table->integer('meeting_id');
            $table->integer('meeting_type_id');
            $table->string('item');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_items');
    }
};