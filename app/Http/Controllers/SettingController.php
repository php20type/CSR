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

        // Update the config file dynamically
        $configPath = config_path('ngo.php');
        $config = File::get($configPath);

        // Replace the initial_fund value
        $updatedConfig = preg_replace(
            "/'initial_fund' => (\d+(\.\d+)?)/",
            "'initial_fund' => " . $request->initial_fund,
            $config
        );

        File::put($configPath, $updatedConfig);

        // Clear config cache to apply changes
        Artisan::call('config:clear');

        return redirect()->route('settings.index')->with('success', 'Initial fund updated successfully!');
    }
}
