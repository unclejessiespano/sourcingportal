<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Touchpoint;
class TouchpointController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $touchpoints = Touchpoint::getTouchpoints();
        return Inertia::render('Admin/Touchpoints/Index', [
            "touchpoints"=>$touchpoints
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Touchpoints/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'=>'required|max:6|unique:touchpoints,code',
            'touchpoint'=>'required',
            'touchpoint_value'=>'required|integer'
        ]);

        if(!empty($request->touchpoint_id)){
            //we're updating a touchpoint
            $touchpoint = Touchpoint::updateTouchpoint($request);
        }
        else{
            //we're creating a touchpoint;
            $touchpoint = Touchpoint::createTouchpoint($request);
        }


        return to_route("admin.touchpoint.show", ["touchpoint_id"=>$touchpoint->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $touchpoint = Touchpoint::getTouchpoint($id);
        return Inertia::render('Admin/Touchpoints/Show', ["touchpoint"=>$touchpoint]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $touchpoint = Touchpoint::getTouchpoint($id);
        return Inertia::render('Admin/Touchpoints/Edit', ["touchpoint"=>$touchpoint]);
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
