<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Sku;
use App\Events\PartImageUploaded;
class SKUController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parts = Sku::getParts();
        return Inertia::render('Parts/Index', ['parts'=>$parts]);
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
        $part = Sku::getSku($id);
        return Inertia::render('Parts/Show', ['part'=>$part]);
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

    public function uploadPartImage(Request $request){
        $validate = $request->validate([
            'part_id'=>'integer|required',
            'file'=>'required'
        ]);

        $sku = Sku::find($request->part_id);

        PartImageUploaded::dispatch($request, $sku);


        return false;
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
