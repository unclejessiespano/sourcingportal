<?php

namespace App\Http\Controllers;

use App\Models\Taskcomment;
use App\Models\Touchpoint;
use Illuminate\Http\Request;
use App\Models\Escalation;
use App\Models\Supplier;
use App\Models\Line;
use App\Models\Task;
use App\Models\Taskcolumn;
use Inertia\Inertia;
class EscalationController extends Controller
{
    public function addTaskComment(Request $request){
        $request->validate([
            'comment'=>'required'
        ]);
        $task = Task::find($request->task_id);
        $comment = Taskcomment::addComment($request->task_id, $request->comment);
        return false;
    }
    public function getTaskComments(Request $request){
        $request->validate(['task_id'=>'required']);
        $comments = Taskcomment::where('task_id', $request->task_id)->get();
        return json_encode($comments);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $escalation_suppliers = Supplier::getSuppliersBelowScore(60);
        $escalations = Escalation::getEscalations();
        $escalations_stats = Escalation::getStats($escalations);
        return Inertia::render('Escalations/Index', ['escalations'=>$escalations, 'escalations_stats'=>$escalations_stats]);
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
        $escalation = Supplier::with('orders', 'shippinglocation', 'scores.touchpoint', 'activity.order', 'activity.sku', 'activity.liner', 'activity.supplierscore.touchpoint', 'activity.touchpoint', 'contacts')->find($id);
        $executiveSummary = Escalation::generateExecutiveSummary($escalation);
        $touchpoints_negative = Touchpoint::getTouchpointsNegativelyAffectingScore($escalation->activity);
        $summary = Escalation::generateAIPrompt($escalation, $touchpoints_negative);
        $supplier_score = Supplier::calculateSupplierScore($escalation->scores);
        return Inertia::render('Escalations/Show', ['escalation'=>$escalation, 'summary'=>$summary, 'supplier_score'=>$supplier_score, 'negative_touchpoints'=>$touchpoints_negative['summary']]);
    }

    public function showLine(string $id, string $identifier)
    {
        //$escalation = Escalation::with('supplier.orders', 'supplier.shippinglocation', 'supplier.scores.touchpoint', 'supplier.activity.order', 'supplier.activity.sku', 'supplier.activity.liner', 'supplier.activity.supplierscore.touchpoint', 'supplier.activity.touchpoint', 'supplier.contacts')->find($id);
        $escalation = Line::with('sku', 'supplier', 'order', 'activity', 'lineActivity', 'shipments')->where('identifier', $identifier)->first();
        $executiveSummary = Escalation::generateExecutiveSummary($escalation);
        $line = Line::with('sku', 'activity.order', 'activity.sku', 'activity.liner', 'activity.touchpoint', 'activity.shipment', 'activity.comment')->where('identifier', $identifier)->first();
        $touchpoints_negative = Touchpoint::getTouchpointsNegativelyAffectingScore($line->activity);
        $summary = Escalation::generateAIPrompt($escalation, $touchpoints_negative, $line);
        $supplier_score = Supplier::calculateSupplierScore($escalation->supplier->scores);
        $taskColumns = Taskcolumn::all();
        $tasks = Task::getTasksByIdentifier($identifier);
        $taskComments = Taskcomment::getTaskComments($tasks);
        return Inertia::render('Escalations/Line', ['tasks'=>$tasks, 'taskcolumns'=>$taskColumns, 'taskcomments'=>$taskComments, 'line'=>$line,'escalation'=>$escalation, 'summary'=>$summary, 'supplier_score'=>$supplier_score, 'negative_touchpoints'=>$touchpoints_negative['summary'], 'identifier'=>$identifier]);
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
    public function updateTaskStatus(Request $request){
        $taskColumn = Taskcolumn::where('column', $request->status)->first();
        Task::updateTaskStatus($request->card_id, $taskColumn->id);
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
