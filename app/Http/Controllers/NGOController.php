<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NGO;
use App\Models\NGOApproval;
use App\Models\User;
use App\Models\NgoBill;
use Illuminate\Support\Facades\Auth;

class NGOController extends Controller
{
    public function index()
    {
        $ngos = NGO::with('approvals.admin')->get(); // Load approvals with admins
        $admins = User::all();
        $initialFund = config('ngo.initial_fund');
        $remainingBudget = $initialFund;

        foreach ($ngos as $ngo) {
            $ngo->remaining_budget = $remainingBudget - ($ngo->total_cost + $ngo->other_costs);
            $remainingBudget = $ngo->remaining_budget;
        }
        return view('ngos.index', compact('ngos', 'admins', 'initialFund', 'remainingBudget'));
    }

    public function create()
    {
        return view('ngos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'team_responsible' => 'required',
            'food_type' => 'required',
            'quantity' => 'required|integer',
            'cost_per_unit' => 'required|numeric',
            'total_cost' => 'required|numeric',
            'payment_mode' => 'required',
            'bill_files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        // Get Initial Fund from Config
        $initialFund = config('ngo.initial_fund');

        // Calculate total cost including other costs
        $totalCost = $request->total_cost + ($request->other_costs ?? 0);

        // Get the last NGO's remaining budget
        $lastNgo = NGO::orderBy('created_at', 'desc')->first();
        $previousRemainingBudget = $lastNgo ? $lastNgo->remaining_budget : $initialFund;

        // Calculate new remaining budget
        $remainingBudget = $previousRemainingBudget - $totalCost;

        // Create new NGO record
        $ngo = NGO::create([
            'name' => $request->name,
            'team_responsible' => $request->team_responsible,
            'food_type' => $request->food_type,
            'quantity' => $request->quantity,
            'cost_per_unit' => $request->cost_per_unit,
            'other_costs' => $request->other_costs ?? 0,
            'total_cost' => $request->total_cost,
            'payment_mode' => $request->payment_mode,
            'remaining_budget' => $remainingBudget,
            'remarks' => $request->remarks,
            'status' => 'pending',
            'approved_by' => json_encode([]),
        ]);

        // Handle multiple bill uploads
        if ($request->hasFile('bill_files')) {
            foreach ($request->file('bill_files') as $file) {
                $billPath = $file->store('bills', 'public');

                NgoBill::create([
                    'ngo_id' => $ngo->id,
                    'user_id' => Auth::id(),
                    'bill_number' => 'BILL-' . time() . rand(1000, 9999),
                    'bill_file' => $billPath,
                    'amount' => $request->total_cost, // or per file if needed
                    'uploaded_by' => auth()->id(), // track who uploaded
                ]);
            }
        }

        return redirect()->route('ngos.index')->with('success', 'NGO created and pending approval.');
    }

    public function approve($id)
    {
        $ngo = NGO::findOrFail($id);
        $adminId = Auth::id();

        // Check if admin already approved
        if (!NGOApproval::where('ngo_id', $id)->where('admin_id', $adminId)->exists()) {
            NGOApproval::create(['ngo_id' => $id, 'admin_id' => $adminId]);
        }

        // If all 3 admins approved, update status to "Done"
        if ($ngo->approvals()->count() >= 3) {
            $ngo->update(['status' => 'Done']);
        }

        return back()->with('success', 'NGO approval updated.');
    }

    public function show($id)
    {
        $ngo = NGO::with('bills')->findOrFail($id);
        return view('ngos.show', compact('ngo'));
    }

    public function edit(NGO $ngo)
    {
        $ngo->load('bills'); // eager load bills
        return view('ngos.edit', compact('ngo'));
    }

    public function update(Request $request, NGO $ngo)
    {
        $request->validate([
            'name' => 'required',
            'team_responsible' => 'required',
            'food_type' => 'required',
            'quantity' => 'required|integer',
            'cost_per_unit' => 'required|numeric',
            'total_cost' => 'required|numeric',
            'payment_mode' => 'required',
            'bill_files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        // Calculate total cost including other costs
        $totalCost = $request->total_cost + ($request->other_costs ?? 0);

        // Get initial fund
        $initialFund = config('ngo.initial_fund');

        // Get all NGOs in ascending order to properly recalculate remaining budget
        $ngos = NGO::orderBy('created_at', 'asc')->get();

        // Update NGO data
        $ngo->update([
            'name' => $request->name,
            'team_responsible' => $request->team_responsible,
            'food_type' => $request->food_type,
            'quantity' => $request->quantity,
            'cost_per_unit' => $request->cost_per_unit,
            'other_costs' => $request->other_costs ?? 0,
            'total_cost' => $request->total_cost,
            'payment_mode' => $request->payment_mode,
            'remarks' => $request->remarks,
        ]);

        // Handle multiple bill uploads
        if ($request->hasFile('bill_files')) {
            foreach ($request->file('bill_files') as $file) {
                $billPath = $file->store('bills', 'public');

                NgoBill::create([
                    'ngo_id' => $ngo->id,
                    'user_id' => Auth::id(),
                    'bill_number' => 'BILL-' . time() . rand(1000, 9999),
                    'bill_file' => $billPath,
                    'amount' => $request->total_cost,
                    'uploaded_by' => auth()->id(),
                ]);
            }
        }

        // Recalculate remaining budget for all NGOs
        $remainingBudget = $initialFund;
        foreach ($ngos as $n) {
            if ($n->id == $ngo->id) {
                $n->total_cost = $request->total_cost;
            }

            $remainingBudget -= ($n->total_cost + $n->other_costs);
            $n->remaining_budget = $remainingBudget;
            $n->save();
        }

        return redirect()->route('ngos.index')->with('success', 'NGO updated successfully!');
    }


    public function destroy(NGO $ngo)
    {
        // Get initial fund
        $initialFund = config('ngo.initial_fund');

        // Delete the NGO
        $ngo->delete();

        // Fetch all remaining NGOs in order of creation
        $ngos = NGO::orderBy('created_at', 'asc')->get();

        // Recalculate remaining budget
        $remainingBudget = $initialFund;
        foreach ($ngos as $n) {
            $remainingBudget -= ($n->total_cost + $n->other_costs);
            $n->remaining_budget = $remainingBudget;
            $n->save();
        }

        return redirect()->route('ngos.index')->with('success', 'NGO deleted successfully, and remaining budget recalculated.');
    }

}
