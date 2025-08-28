<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NgoBill;
use Illuminate\Support\Facades\Storage;

class BillController extends Controller
{
    public function index()
    {
        $bills = NgoBill::whereHas('ngo')->get(); // Fetch only bills with an NGO
        return view('bills.index', compact('bills'));
    }

    public function destroy($id)
    {
        $bill = NgoBill::findOrFail($id);

        // Delete the file from storage (if exists)
        if ($bill->bill_file && Storage::disk('public')->exists($bill->bill_file)) {
            Storage::disk('public')->delete($bill->bill_file);
        }
        // Delete the record from the database
        $bill->delete();

        return back()->with('success', 'Bill deleted successfully!');
    }
}
