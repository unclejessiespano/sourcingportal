<?php

namespace App\Http\Controllers;


use App\Models\Agendaitem;
use App\Models\Meeting;
use App\Models\MeetingItem;
use App\Models\MeetingItemType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Auth;

class MeetingController extends Controller
{
    public function addInput(Request $request){
        $inputField = "input[".$request->type_id."]";
        $request->validate(['input.'.$request->type_id=>'required', 'type'=>'required']);

        $meetingItem = MeetingItem::addMeetingItem($request);
        return false;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meetings = Meeting::all();
        return Inertia("Meetings/Index", ['meetings'=>$meetings]);
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
    public function show($meeting_id)
    {
        //TODO - Investigate what happens if an ingestion doesn't complete properly. I think the meeting ids need to be looked at. The result is  meeting without any agenda items.
        $meeting = Meeting::with(['user','supplier.contacts', 'agendaitems.line.order', 'agendaitems.line.sku', 'agendaitems.line.supplier.user', 'agendaitems.line.activity', 'agendaitems.line.lineactivity'])->find($meeting_id);
        $meetingItemTypes = MeetingItemType::orderBy('order')->get();
        $meetingItems = MeetingItem::getItemsByMeetingId($meeting_id);
        $agendaItems = Agendaitem::formatAgendaItems($meeting->agendaitems);
        $attendees = Meeting::generateAttendees($meeting);
        return Inertia("Meetings/Show", ['attendees'=>$attendees, 'meetingItems'=>$meetingItems, 'meetingItemTypes'=>$meetingItemTypes, 'meeting'=>$meeting, 'agendaItems'=>$agendaItems['orders'], 'agendaStats'=>$agendaItems['stats']]);
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
