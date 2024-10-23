<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    /*
[0] => Document Date
[1] => Item Category
[2] => Plant
[3] => Purchasing Document
[4] => Item
[5] => Purchasing Group
[6] => Name of Vendor
[7] => Material
[8] => Short Text
[9] => Delivery Date
[10] => Scheduled Quantity
[11] => Quantity Received
[12] => Still to be delivered (qty)
[13] => Still to be delivered (value)
[14] => Order Unit
[15] => Order Price Unit
[16] => Price Unit
[17] => Net price
[18] => Currency
[19] => Purchase Requisition
[20] => Req. Tracking Number
[21] => Stat.-Rel. Del. Date
    */

    public function up(): void
    {
        Schema::create('lines', function (Blueprint $table) {
            $table->id();
            $table->integer('po_id');
            $table->integer('sku_id');
            $table->string('line');
            $table->date('document_date');
            $table->date('delivery_date')->nullable();
            $table->date('commit_date')->nullable();
            $table->date('stat_del_date')->nullable();
            $table->integer('qty');
            $table->string('order_unit');
            $table->string('order_price_unit');
            $table->decimal('net_price', 16,8);
            $table->string('currency');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lines');
    }
};
