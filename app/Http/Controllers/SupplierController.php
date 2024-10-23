<?php

namespace App\Http\Controllers;

use App\Exports\OorExport;
use App\Models\Activity;
use App\Models\Column;
use App\Models\Supplierscore;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\Line;
use App\Models\Contact;
use App\Models\User_Supplier;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use App\Mail\DataIngested;
use Illuminate\Support\Facades\Mail;
class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::getSuppliers();
        $user_suppliers = User_Supplier::getSuppliers();
        return Inertia::render('Suppliers/Index', [
            "suppliers"=>$user_suppliers
        ]);
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
    public function activity(string $slug)
    {
        $supplier = Supplier::getSupplierBySlug($slug);
        $orders = Order::with(['lines.sku', 'supplier'])->where('supplier_id', $supplier->id)->get();
        $supplierScoreData = Supplierscore::getScoreData($supplier->id);
        return Inertia::render('Suppliers/Activity', [
            "supplier"=>$supplier,
            "orders"=>$orders,
            "activity"=>$supplier->activity,
            "supplier_scores"=>$supplierScoreData
        ]);
    }
    public function adminSupplierScores(){
        $suppliers = Supplier::getSuppliers();
        return Inertia::render('Admin/Suppliers/Index', ['suppliers'=>$suppliers]);
    }
    public function adminSupplierScore($slug){
        $supplier = Supplier::getSupplierBySlug($slug);
        $scores = Supplier::prepareScores($supplier->scores);
        return Inertia::render('Admin/Suppliers/Show', ['supplier'=>$supplier, 'scores'=>$scores]);
    }
    public function company(string $slug)
    {
        $supplier = Supplier::getSupplierBySlug($slug);
        $orders = Order::with(['lines.sku', 'supplier'])->where('supplier_id', $supplier->id)->get();
        return Inertia::render('Suppliers/Company', [
            "supplier"=>$supplier,
            "orders"=>$orders
        ]);
    }
    public function generateSupplierInfo(Request $request){
        $supplier = Supplier::find($request->supplier_id);
        $aiSummary = Supplier::getAISummary($supplier);
        $json = json_decode($aiSummary);
        $content = $json->choices[0]->message->content;

        $supplier->description = $content;
        if(!$supplier->save()){
            Log::error("Couldn't save the supplier description for supplier ".$supplier->id);
        }
        return to_route('supplier.company', ['slug'=>$supplier->slug]);
    }
    public function mapcolumns($columns, $supplier_id){
        $columns = Column::getColumns();
        return Inertia::render('Suppliers/Mapcolumns', ['columns'=>$columns, 'supplier_id'=>$supplier_id]);
    }
    public function network(string $slug)
    {
        $supplier = Supplier::getSupplierBySlug($slug);
        $orders = Order::with(['lines.sku', 'supplier'])->where('supplier_id', $supplier->id)->get();
        $network = Supplier::formatNetwork($supplier->network);
        return Inertia::render('Suppliers/Network', [
            "supplier"=>$supplier,
            "network"=>$network
        ]);
    }
    public function saveContact(Request $request){
        $request->validate([
            "supplier_id"=>"required|integer",
            "fname"=>"required",
            "lname"=>"required",
            "email"=>"required|email:rfc,dns"
        ]);

        $supplier = Supplier::find($request->supplier_id);

        $model = Contact::saveContact($request);
        return to_route('supplier.company', ['slug'=>$supplier->slug]);
    }
    public function saveInfo(Request $request){
        $request->validate([
            "supplier_id"=>"required|integer",
        ]);

        if(!empty($request->url)){
            $request->validate([
                "url"=>"url:http,https"
            ]);
        }

        $model = Supplier::updateInfo($request);
        return to_route('supplier.company', ['slug'=>$model->slug]);
    }
    public function savePlant(Request $request){
        $supplier = Supplier::find($request->supplier_id);
        $request->validate([
            "supplier_id"=>"required|integer",
            "address"=>"required",
            "city"=>"required",
            "state"=>"required",
            "zip"=>"required",
            "country"=>"required"
        ]);

        $address = $request->address.' '.$request->city.', '.$request->state.' '.$request->zip.' '.$request->country;
        $geocoded_data = \GoogleMaps::load('geocoding')->setParam (['address' =>$address])->get();
        $geocoded_data_response = json_decode($geocoded_data);

        if($geocoded_data_response->status=="OK"){
            $request->lat = $geocoded_data_response->results[0]->geometry->location->lat;
            $request->lng = $geocoded_data_response->results[0]->geometry->location->lng;
        }
        else{
            Log::error("Couldn't get the geocoded data for address: ".$address);
        }
        $model = Supplier::savePlant($request);
        return to_route('supplier.company', ['slug'=>$supplier->slug]);
    }
    public function saveSupplier(Request $request){
        $x = Supplier::find($request->supplier_id);
        $request->validate([
            "supplier_id"=>"required|integer",
            "supplier_name"=>"required",
            "country"=>"",
            "city"=>"",
            "state"=>"",
            "zip"=>""
        ]);

        $supplier = Supplier::saveSupplier($request);

        return to_route("supplier.network", ['slug'=>strtolower(str_replace(" ", "-", $x->slug))]);
    }
    public function score(string $slug)
    {
        $supplier = Supplier::getSupplierBySlug($slug);
        $orders = Order::with(['lines.sku', 'supplier'])->where('supplier_id', $supplier->id)->get();
        return Inertia::render('Suppliers/Score', [
            "supplier"=>$supplier,
            "orders"=>$orders
        ]);
    }
    public function show(string $slug)
    {
        $supplier = Supplier::getSupplierBySlug($slug);
        $stats = Supplier::getStats($supplier->id);
        $averageDaysLate = Supplier::getAverageDaysPastDue($supplier->id);
        $sankeyLineStats = Supplier::getSankeyLineStats($supplier->id);
        $orders = Order::with(['lines.sku', 'supplier'])->where('supplier_id', $supplier->id)->get();
        $lines = Line::with(['order.supplier','sku','activity','lineactivity'])->where('active','y')->where('supplier_id', $supplier->id)->get();
        $lines2 = Line::getLinesByOrders($orders);
        $activity = Activity::getActivity($supplier->id);
        $commitsForCalendar = Supplier::getCommitsForCalendar($supplier->id);
        //Mail::to('kruiz@corbus.com')->send(new DataIngested());

        return Inertia::render('Suppliers/Dashboard', [
            "supplier"=>$supplier,
            "orders"=>$orders,
            "lines"=>$lines,
            "activity"=>$activity,
            "sankeyLineStats"=>$sankeyLineStats,
            "stats"=>$stats,
            "averageDaysLate"=>$averageDaysLate,
            "commitsForCalendar"=>$commitsForCalendar
        ]);
    }
    public function lines(string $slug)
    {
        $supplier = Supplier::getSupplierBySlug($slug);
        $orders = Order::with(['lines.sku', 'supplier'])->where('supplier_id', $supplier->id)->get();
        $lines = Line::getLinesBySupplierId($supplier->id);
        $lines2 = Line::getLinesByOrders($orders);
        $activity = Activity::getActivity($supplier->id);

        return Inertia::render('Suppliers/Show', [
            "supplier"=>$supplier,
            "orders"=>$orders,
            "lines"=>$lines,
            "activity"=>$activity
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
    public function exportlines(string $id){
        return Excel::download(new OorExport($id), 'oor.xlsx');
        return $id;
    }
}
