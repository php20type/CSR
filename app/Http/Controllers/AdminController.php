<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NGO;

class AdminController extends Controller
{
    public function index()
    {
        $total_ngos = NGO::count();
        $approved_ngos = NGO::where('status', 'approved')->count();
        $pending_ngos = NGO::where('status', 'pending')->count();
        $remaining_budget = NGO::sum('remaining_budget');
        $ngos = NGO::latest()->take(5)->get(); // Fetch recent NGOs

        return view('admin.dashboard', compact('total_ngos', 'approved_ngos', 'pending_ngos', 'remaining_budget', 'ngos'));
    }
}
