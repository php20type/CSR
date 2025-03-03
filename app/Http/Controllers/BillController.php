<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::whereHas('ngo')->get(); // Fetch only bills with an NGO
        return view('bills.index', compact('bills'));
    }

    public function destroy($id)
    {
        $bill = Bill::findOrFail($id);

        // Delete the file from storage
        Storage::delete('public/' . $bill->bill_file);

        // Delete the record from the database
        $bill->delete();

        return back()->with('success', 'Bill deleted successfully!');
    }
}
