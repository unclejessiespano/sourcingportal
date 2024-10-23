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
        Schema::create('deltas', function (Blueprint $table) {
            $table->id();
            $table->string('identifier');
            $table->integer('po_id');
            $table->integer('sku_id');
            $table->integer('line');
            $table->string('colummn');
            $table->string('prev_value');
            $table->string('current_value');
            $table->string('change');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deltas');
    }
};
