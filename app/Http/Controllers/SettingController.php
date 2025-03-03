<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;


use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Fetch the current initial fund from config
        $initialFund = config('ngo.initial_fund');
        return view('settings.index', compact('initialFund'));
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
}
