<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\LineActivity;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Line;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lines = Line::getOpenLines();
        $orders = Order::with('supplier', 'lines', 'plant')->get();
        return Inertia("Orders/Index", ['lines'=>$lines, 'orders'=>$orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::getOrder($id);
        $lines = Line::with(['order.supplier','sku','activity.touchpoint.lineactivity','lineactivity'])->where('active','y')->where('po_id', $order->id)->get();
        $activity = Activity::getActivity("", $order->id, "","");
        $lineActivities = LineActivity::all();
        return Inertia("Suppliers/PO", [
            "lines"=>$lines,
            "lineActivities"=>$lineActivities,
            "activity"=>$activity,
            "order"=>$order,
            "supplier"=>$order->supplier
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
