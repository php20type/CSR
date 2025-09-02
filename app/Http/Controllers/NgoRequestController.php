<?php

namespace App\Http\Controllers;

use App\Models\NgoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NgoRequestController extends Controller
{
    public function create()
    {
        return view('ngo_requests.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'ngo_name' => 'required|string|max:255',
            'cost' => 'nullable|numeric',
            'note' => 'nullable|string',
        ]);

        NgoRequest::create($request->all());

        Mail::send('emails.fund_request', [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'ngo_name' => $request->ngo_name,
            'cost' => $request->cost,
            'note' => $request->note,
        ], function ($message) {
            $message->to(['php20.department@gmail.com', 'bde3.sxope@gmail.com', 'bde55.department@gmail.com'])
                ->subject('🔔 New Fund Request Submitted');
        });
        return redirect()->back()->with('success', 'Your request has been submitted successfully!');
    }

    public function showFundRequest()
    {
        $requests = NgoRequest::latest()->paginate(10);
        return view('ngo_requests.show_request', compact('requests'));
    }
}

