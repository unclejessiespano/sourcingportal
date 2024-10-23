<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Line;
class OorExport implements FromView
{
    protected $id;

    function __construct($id){
        $this->id = $id;
    }
    /**
    * @return OOR $oor
    */
    public function view():view
    {
        $dates = [];
        $orders = [];
        $lines = [];
        $lines = Line::with(['order.plant', 'order.supplier', 'sku'])->get();
        $orders = Order::with(['lines.sku', 'supplier'])->where('supplier_id', $this->id)->get();

        foreach($orders as $order){

            $orders_array[$order->PO][] = $order->PO;
            $late_lines = 0;
            foreach($order->lines as $line){
                if($line->stat_del_date < $line->delivery_date){
                    $late_lines++;
                }
            }
            $dates[$order->document_date]['lines'] = $order->lines->count();
            $dates[$order->document_date]['orders'] = count($orders_array);
            $dates[$order->document_date]['late_lines'] = $late_lines;
        }

        return view('exports.oor',[
            'orders'=>$orders
        ]);
    }
}
