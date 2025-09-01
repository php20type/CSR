<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use App\Models\AdditionalFund;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Fetch the current initial fund from config
        $initialFund = config('ngo.initial_fund');
        $additionalFund = AdditionalFund::orderBy('release_date', 'desc')->get();
        $totalFund = $initialFund + $additionalFund->sum('amount');
        return view('settings.index', compact('initialFund', 'totalFund', 'additionalFund'));
    }

    public function updateInitialFund(Request $request)
    {
        $request->validate([
            'initial_fund' => 'required|numeric|min:0'
        ]);

        // Update the .env file dynamically
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);
        $newEnvContent = preg_replace(
            "/NGO_INITIAL_FUND=.*/",
            "NGO_INITIAL_FUND=" . $request->initial_fund,
            $envContent
        );

        file_put_contents($envPath, $newEnvContent);

        // Clear config cache to apply changes
        Artisan::call('config:clear');

        return redirect()->route('settings.index')->with('success', 'Initial fund updated successfully!');
    }

    // Store new additional fund
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'release_date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        AdditionalFund::create([
            'added_by' => Auth::id(),
            'amount' => $request->amount,
            'release_date' => $request->release_date,
            'note' => $request->note,
        ]);

        return redirect()->back()->with('success', 'Additional Fund added successfully.');
    }

    public function sendTestMail()
    {
        Mail::send('emails.test', ['name' => 'Gmail'], function ($message) {
            $message->to('crazycoder09@gmail.com')
                ->subject('Test Mail with View');
        });
    }
}
