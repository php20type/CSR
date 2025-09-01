<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NGO;
use App\Models\AdditionalFund;
use DB;

class AdminController extends Controller
{
    public function index()
    {
        $total_ngos = NGO::count();
        $approved_ngos = NGO::where('status', 'approved')->count();
        $pending_ngos = NGO::where('status', 'pending')->count();
        // Get initial fund from config
        $initialFund = config('ngo.initial_fund');
        // Sum all additional funds from DB
        $additionalFunds = AdditionalFund::sum('amount');

        $totalFund = $initialFund;

        if ($additionalFunds) {
            $totalFund = $initialFund + $additionalFunds;
        }
        // Calculate remaining fund correctly
        $total_expenses = NGO::sum(DB::raw('total_cost + other_costs'));
        $remainingFund = $totalFund - $total_expenses;
        $ngos = NGO::orderBy('created_at', 'asc')->get(); // Fetch recent NGOs
        foreach ($ngos as $ngo) {
            $ngo->remaining_budget = $totalFund - ($ngo->total_cost + $ngo->other_costs);
            $totalFund = $ngo->remaining_budget;
        }
        return view('admin.dashboard', compact('total_ngos', 'approved_ngos', 'pending_ngos', 'remainingFund', 'ngos', 'additionalFunds', 'totalFund', 'initialFund'));
    }
}
