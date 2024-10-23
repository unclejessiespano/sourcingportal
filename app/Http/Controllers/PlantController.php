<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plants2 = Plant::with('orders.lines', 'orders.supplier')->get();
        //$plant_markers = Plant::getMapMarkers($plants);
        $plants = Plant::getPlants();
        return Inertia::render('Plants/Index', [
            "plants"=>$plants,
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
        $validated = $request->validate([
            "plant_name"=>"required",
            "country"=>"required",
            "address"=>"required",
            "city"=>"required",
            "state"=>"required",
            "zip"=>"required"
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
        $model = Plant::savePlant($request);
        return to_route('plants');
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
}
