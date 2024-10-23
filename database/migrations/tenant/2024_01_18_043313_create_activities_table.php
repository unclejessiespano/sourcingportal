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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id');
            $table->integer('po_id')->nullable();
            $table->integer('sku_id')->nullable();
            $table->integer('line_id')->nullable();
            $table->integer('touchpoint_id');
            $table->integer('supplierscore_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
