<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\Sku;
use App\Models\Line;
use App\Models\Supplierscore;
use App\Models\Touchpoint;
use App\Models\Activity;
class DeleteData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes data from suppliers, pos, skus, lines, and supplierscores. Be careful.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $suppliers = Supplier::all();
        foreach($suppliers as $supplier){
            $supplier->delete();
        }

        $orders = Order::all();
        foreach($orders as $order){
            $order->delete();
        }

        $skus = Sku::all();
        foreach($skus as $sku){
            $sku->delete();
        }

        $lines = Line::all();
        foreach($lines as $line){
            $line->delete();
        }

        $supplierscores = Supplierscore::all();
        foreach($supplierscores as $supplierscore){
            $supplierscore->delete();
        }

        $activities = Activity::all();
        foreach($activities as $activity){
            $activity->delete();
        }

        return false;
    }
}
