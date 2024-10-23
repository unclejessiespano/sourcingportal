<?php

namespace App\Http\Controllers;

use App\Events\OORUploaded;
use App\Events\SupplierOORUploaded;
use App\Imports\SupplierColumnMapNeededImport;
use App\Models\Activity;
use App\Models\Agendaitem;
use App\Models\Column;
use App\Models\Ingestion;
use App\Models\LineActivity;
use App\Models\Shipment;
use App\Models\Supplier;
use App\Models\Supplierscore;
use App\Models\Touchpoint;
use App\Models\Comment;
use App\Models\SupplierColumnMap;
use Illuminate\Http\Request;
use App\Models\Line;
use App\Models\Ups;
use Inertia\Inertia;
use App\Exports\OorExport;
use Maatwebsite\Excel\Facades\Excel;
use Auth;

class LineController extends Controller
{
    public function addComment(Request $request){
        $validated = $request->validate([
            'id'=>'required|integer',
            'supplier_id'=>'required|integer',
            'po_id'=>'required|integer',
            'sku_id'=>'required|integer',
            'line'=>'required|integer',
            'identifier'=>'required',
            'comment'=>'required'
        ]);

        //get the touchpoint
        $touchpoint = Touchpoint::getByCode('comlin');

        //add the score
        $supplierscore = Supplierscore::addScore($request->supplier_id, $touchpoint);

        //add the activity
        $activity = Activity::addActivity($request->identifier, auth()->user()->id, $request->supplier_id, $request->po_id, $request->sku_id, $request->line, $touchpoint->id, $supplierscore->id);

        //add the comment
        $comment = Comment::addComment($activity->id, $request->id, $request->po_id, $request->sku_id, $request->line, $request->identifier, $request->comment);

        //save the comment back to the activity
        Activity::addCommentToActivity($comment->id, $activity);

        return false;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function saveCommit(Request $request){


        $commit = Line::setCommitForLine($request->commit_date, $request->po, $request->sku, $request->line);

        if($request->agenda_item_id){
            $agenda_item = Agendaitem::find($request->agenda_item_id);
            $agenda_item->complete='y';
            if(!$agenda_item->save()){
                Log::error("Couldn't flip the complete bit for agenda item #".$request->agenda_item_id);
            }
        }

        return false;
    }
    public function saveLineActivity(Request $request){
        //get the line
        $line = Line::getLine($request->po_id, $request->sku_id, $request->line);

        //get the supplier
        $supplier = Supplier::find($line->order->supplier->id);

        //get the line activity
        $lineActivity = LineActivity::with('touchpointmodel')->where('slug', $request->slug)->first();

        //save the line activity to the line
        $update_line = Line::saveLineActivity($line, $lineActivity);

        //save the score
        $score = Supplierscore::addScore($line->order->supplier_id, $lineActivity->touchpoint());

        //record the partial shipment if necessary
        $shipment = Shipment::recordShipment($request);

        //save the activity
        $identifier = $line->id;
        $supplier_id = $line->order->supplier->id;
        $po_id = $request->po_id;
        $sku_id = $request->sku_id;
        $line_id = $request->line;
        $touchpoint_id = $lineActivity->touchpointmodel->id;

        $score_id = $score->id;
        Activity::addActivity($line->identifier, Auth::id(), $line->order->supplier->id, $request->po_id, $request->sku_id, $request->line, $lineActivity->touchpointmodel->id, $score->id, $shipment->id);

        return to_route($request->return_to_route, ['slug'=>$supplier->slug, 'po'=>$po_id, 'sku'=>$sku_id, 'line_id'=>$line_id]);
    }
    public function saveLineDelayedReason(Request $request){
        $request->validate([
            'supplier_id'=>'required|integer',
            'po_id'=>'required|integer',
            'sku_id'=>'required|integer',
            'line'=>'required',
            'identifier'=>'required',
            'reason'=>'required',
            'return_to_route'=>'required'
        ]);

        //get the line
        $line = Line::getLine($request->po_id, $request->sku_id, $request->line);

        //get the supplier
        $supplier = Supplier::find($line->order->supplier->id);

        //get the line activity
        $lineActivity = LineActivity::with('touchpointmodel')->where('slug', $request->slug)->first();

        //save the line activity to the line
        $update_line = Line::saveLineActivity($line, $lineActivity);

        //save the score
        $score = Supplierscore::addScore($line->order->supplier_id, $lineActivity->touchpoint());

        //save the activity
        $identifier = $line->id;
        $supplier_id = $line->order->supplier->id;
        $po_id = $request->po_id;
        $sku_id = $request->sku_id;
        $line_id = $request->line;
        $touchpoint_id = $lineActivity->touchpointmodel->id;

        $score_id = $score->id;
        $activity = Activity::addActivity($line->identifier, Auth::id(), $line->order->supplier->id, $request->po_id, $request->sku_id, $request->line, $lineActivity->touchpointmodel->id, $score->id, 0);

        //save the note
        $x = Activity::find($activity->id);
        $x->notes = $request->reason;
        if(!$x->save()){
            Log::error("Couldn't save note for activity #".$activity->id);
            return false;
        }

        return to_route($request->return_to_route, ['slug'=>$supplier->slug, 'po'=>$request->po_id, 'sku'=>$request->sku_id, 'line_id'=>$request->line]);
    }
    public function search(Request $request){
        $lines = Line::searchLines($request);
        return Inertia::render("SearchResults", ["lines"=>$lines]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $supplier, string $po, string $sku, string $line_id)
    {
        $supplier = Supplier::getSupplier($supplier);
        $line = Line::with(['shipments', 'activity.user', 'activity.touchpoint.lineactivity', 'activity.comment.user', 'order.supplier', 'sku', 'supplier'])->where('active', 'y')->where('po_id', $po)->where('sku_id', $sku)->where('line', $line_id)->first();
        $tracking_info = Ups::getTracking($line->shipments);
        $activity = Activity::getActivity("", $po, $sku, $line_id);
        $lineActivities = LineActivity::all();
        return Inertia::render('Suppliers/Line', [
            "line"=>$line,
            "lineActivities"=>$lineActivities,
            "activity"=>$activity,
            "supplier"=>$supplier,
            "tracking_info"=>$tracking_info
        ]);
    }
    public function showIdentifier(string $supplier, string $identifier)
    {
        $supplier = Supplier::getSupplier($supplier);
        $line = Line::with(['order', 'sku', 'shipments', 'activity.user', 'activity.touchpoint.lineactivity', 'activity.comment.user', 'order.supplier', 'sku', 'supplier'])->where('active', 'y')->where('identifier', $identifier)->first();
        $tracking_info = Ups::getTracking($line->shipments);
        $activity = Activity::getActivity("", $line->order->PO, $line->sku->sku, null);
        $lineActivities = LineActivity::all();
        return Inertia::render('Suppliers/Line', [
            "line"=>$line,
            "lineActivities"=>$lineActivities,
            "activity"=>$activity,
            "supplier"=>$supplier,
            "tracking_info"=>$tracking_info
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

    public function upload(Request $request){
        $validated = $request->validate([
            //'file'=>'file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/excel'
            //'file'=>'file'
        ]);
        foreach($request->file('file') as $file){
            //turn all the lines in the database to active='n'
            Line::deactivateAllLines();

            //processes the logic for ingesting the data
            OORUploaded::dispatch($request, $file);
        }

        return false;
    }
    public function uploadSupplierOOR(Request $request){
        session()->forget(['supplier_id']);

        $validated = $request->validate(['file'=>'required', 'supplier_id'=>'required']);
        $supplier = Supplier::find($request->supplier_id);
        session(['supplier_id'=>$request->supplier_id]);
        //does the supplier have a map?
        if(SupplierColumnMap::doesSupplierMapExist($request->supplier_id)){
            //they have a map, we can ingest
            SupplierOORUploaded::dispatch($request, $request->file);
        }
        else{
            //they don't have a map, we need to create one
            $file = $request->file('file');
            $file = $file[0];
            $import = (new SupplierColumnMapNeededImport)->toCollection($file->store('oors'));
            $supplier_columns = Ingestion::getColumnNames($import[0][0]);
            $columns = Column::getColumns();
            return Inertia::render('Suppliers/Mapcolumns', ['columns'=>$columns, 'supplier_columns'=>$supplier_columns, 'supplier'=>$supplier]);
        }
        return false;
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export(){
        return Excel::download(new OorExport, 'oor.xlsx');
    }
    public function getTracking(Request $request){
        $x = [];
        foreach($request->shipments as $shipment){
            $tracking_info = Ups::getTracking($shipment['tracking_code']);
            $x[] = $tracking_info;
        }

        return $x;
    }
}
