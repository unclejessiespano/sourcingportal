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
        Schema::table('shippinglocations', function (Blueprint $table) {
            if(!Schema::hasColumn('shippinglocations', 'state')) {
                $table->string('state')->after('city')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shippinglocations', function (Blueprint $table) {
            //
        });
    }
};
