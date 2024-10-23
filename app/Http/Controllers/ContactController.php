<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {}

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

    public function deleteContact(Request $request){
        $request->validate([
            "supplier_id"=>"required|integer",
            "contact_id"=>"required|integer"
        ]);
        $supplier = Supplier::find($request->supplier_id);

        Contact::deleteContact($request->contact_id);
        return to_route('supplier.company', ['slug'=>$supplier->slug]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
