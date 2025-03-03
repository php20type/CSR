<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NGO;
use DB;

class AdminController extends Controller
{
    public function index()
    {
        $total_ngos = NGO::count();
        $approved_ngos = NGO::where('status', 'approved')->count();
        $pending_ngos = NGO::where('status', 'pending')->count();
        // Get initial fund from config
        $initial_fund = config('ngo.initial_fund');

        // Calculate remaining budget correctly
        $total_expenses = NGO::sum(DB::raw('total_cost + other_costs'));
        $remaining_budget = $initial_fund - $total_expenses;
        $ngos = NGO::latest()->take(10)->get(); // Fetch recent NGOs

        return view('admin.dashboard', compact('total_ngos', 'approved_ngos', 'pending_ngos', 'remaining_budget', 'ngos'));
    }
}
