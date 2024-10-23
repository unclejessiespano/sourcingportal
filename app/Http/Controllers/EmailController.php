<?php

namespace App\Http\Controllers;

use App\Models\Escalation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Mail\WeeklyUpdate;
use App\Mail\DataIngested;
use App\Mail\SupplierRequest;
use App\Models\Email;
use App\Models\Line;
use App\Models\Supplier;
class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function dataIngested(){
        $date = Email::getDateForWeeklyUpdate();
        $linestats = Line::getStats();
        $linesDueInWeeks = Line::getLinesDueInWeek();
        $escalations = Escalation::getEscalationsForEmail();
        $lineChanges = Line::getLineChangeStats(2);
        $tablePastDue = Line::getEmailData_PercentPastDueSuppliers();
        $tableCommits = Line::getEmailData_PercentCommitSuppliers();
        $summary = Email::getIngestionSummary($date, $lineChanges, $tablePastDue, $tableCommits, $linesDueInWeeks, $escalations);
        $markdown_table_percentPastDueSuppliers = View::make('emails.table.percentPastDueSuppliers', ['data'=>$tablePastDue])->render();
        $markdown_table_percentCommitsSuppliers = View::make('emails.table.percentCommitsSuppliers', ['data'=>$tableCommits])->render();
        return new DataIngested(
            $date,
            $markdown_table_percentPastDueSuppliers,
            $markdown_table_percentCommitsSuppliers,
            $lineChanges,
            $summary
        );
    }
    public function weeklyupdate(){
        $date = Email::getDateForWeeklyUpdate();
        $linestats = Line::getStats();
        $lineChanges = Line::getLineChangeStats(2);
        $tablePastDue = Line::getEmailData_PercentPastDueSuppliers();
        $markdown_table_percentPastDueSuppliers = View::make('emails.table.percentPastDueSuppliers', ['data'=>$tablePastDue])->render();
        return new WeeklyUpdate(
            $date,
            $markdown_table_percentPastDueSuppliers,
            $lineChanges
        );
    }

    public function supplierRequest($supplier_id){
        $supplier = Supplier::with('contacts', 'lines_.order', 'lines_.sku')->find($supplier_id);
        $commitsNeeded = Line::getCommitsNeededFromSupplier($supplier);
        $dueThisWeek = Line::getLinesDueThisWeek($supplier);
        $date = Email::getDateForWeeklyUpdate();
        $linestats = Line::getStats();
        $lineChanges = Line::getLineChangeStats(2);
        $tablePastDue = Line::getEmailData_PercentPastDueSuppliers();
        $markdown_table_percentPastDueSuppliers = View::make('emails.table.percentPastDueSuppliers', ['data'=>$tablePastDue])->render();
        $markdown_table_commitsNeeded = View::make('emails.table.commitsNeeded', ['data'=>$commitsNeeded])->render();
        $markdown_table_dueThisWeek = View::make('emails.table.dueThisWeek', ['data'=>$dueThisWeek])->render();
        return new SupplierRequest(
            $supplier,
            $markdown_table_commitsNeeded,
            $markdown_table_dueThisWeek,
            $lineChanges,
            $commitsNeeded,
            $dueThisWeek
        );
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
}
