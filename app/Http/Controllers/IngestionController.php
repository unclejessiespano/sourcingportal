<?php

namespace App\Http\Controllers;

use App\Models\Supplierscore;
use Illuminate\Http\Request;
use App\Models\Ingestion;
use App\Models\Line;
use Inertia\Inertia;
use App\Exports\RandomOORExport;
class IngestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingestions = Ingestion::getIngestions();
        return Inertia::render('Ingestions/Index', [
            "ingestions"=>$ingestions,
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
    public function show(string $id)
    {
        //
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
    public function generateOOR(){
        return (new RandomOORExport)->download('oor.xlsx');
    }
    public function undoIngestion(Request $request){
        //delete ingestion
        $next_ingestion_id = Ingestion::deleteIngestion($request->ingestion_id);

        //delete supplierscores
        Supplierscore::deleteScoresFromIngestion($request->ingestion_id);

        //delete lines
        Line::deleteLinesFromIngestion($request->ingestion_id, $next_ingestion_id);

        return to_route('ingestions');
    }
    public function updateSupplierScores(){
        Ingestion::updateSupplierScores();
        return false;
    }
}
