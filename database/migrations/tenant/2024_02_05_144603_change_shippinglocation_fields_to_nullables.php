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
            $table->string('lat')->after('country')->nullable()->change();
            $table->string('lng')->after('lat')->nullable()->change();
            $table->string('coordinates')->after('lng')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nullables', function (Blueprint $table) {
            //
        });
    }
};
