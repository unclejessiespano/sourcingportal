<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Line;
use App\Models\Supplier;
use App\Models\Chart;
class DashboardController extends Controller
{
    public function index(){
        $linesCommits = Line::getLinesCommitsForDashbord(Auth()->id());
        $stats = Line::getStats();
        $chart_commitPercentage = Chart::formatData("guage", $stats['commit_percentage']);
        $sankeySupplyChain = Supplier::getSankeySupplyChain();
        $user = Auth::user()->load(['team']);
        $teamStats = Line::getTeamStats($user->team);
        $sankeyLineStats = Supplier::getSankeyLineStats();
        $supplyChainTree = Supplier::getSupplyChainTree();
        $supplierLatePercentage = Line::getGoogleChartData_PercentPastDueSuppliers();

        return Inertia::render('Dashboard', ['teamStats'=>$teamStats, 'sankeySupplyChain'=>$sankeySupplyChain, 'supplyChainTree'=>$supplyChainTree, 'sankeyLineStats'=>$sankeyLineStats, 'latePercentage'=>$stats['late_percentage'], 'commitPercentage'=>$stats['commit_percentage'], 'supplierPastDue'=>$supplierLatePercentage]);
    }
}
