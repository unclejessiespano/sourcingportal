<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\FinishedPart;
use App\Models\Sku;
use App\Events\FinishedPartAdded;
class FinishedPartsController extends Controller
{
    public function addSku(Request $request){
        $request->validate(['selectedSku'=>'required', 'finishedgood_id'=>'required']);

        Sku::addSkuToFinishedPart($request->selectedSku['id'], $request->finishedgood_id);

        return to_route('finishedparts.show', ['id'=>$request->finishedgood_id]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $finishedparts = FinishedPart::whereNull('parent_id')->get();
        return Inertia::render('FinishedParts/Index', ['finishedparts'=>$finishedparts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function removesku(Request $request){
        $request->validate(['sku_id'=>'required', 'finishedgood_id'=>'required']);
        FinishedPart::removeSku($request);

        return to_route('finishedparts.show', ['id'=>$request->finishedgood_id]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name'=>'required']);

        FinishedPartAdded::dispatch($request);

        return to_route('finishedparts');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $finishedpart = FinishedPart::with('parts.sku.detail', 'parts.sku.lines.supplier')->where('id',$id)->first();
        $supplyChain = FinishedPart::buildSupplyChain($finishedpart->parts);
        $commitsForCalendar = FinishedPart::getCommitsForCalendar($finishedpart->parts);
        $partDecsription = FinishedPart::writePartDescription($finishedpart);
        $skus = Sku::all();
        return Inertia::render('FinishedParts/Show', ['skus'=>$skus, 'finishedpart'=>$finishedpart, 'supplychain'=>$supplyChain, 'commitsForCalendar'=>$commitsForCalendar, 'partDescription'=>$partDecsription]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return false;
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
