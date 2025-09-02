<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NGOController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\SettingController;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', [AdminController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/ngos', [NGOController::class, 'index'])->name('ngos.index');
    Route::get('/ngos/create', [NGOController::class, 'create'])->name('ngos.create');
    Route::post('/ngos/store', [NGOController::class, 'store'])->name('ngos.store');
    Route::get('/ngos/{ngo}/edit', [NGOController::class, 'edit'])->name('ngos.edit');
    Route::post('/ngos/{ngo}/update', [NGOController::class, 'update'])->name('ngos.update');
    Route::delete('/ngos/{ngo}/delete', [NGOController::class, 'destroy'])->name('ngos.destroy');
    Route::post('/ngos/approve/{id}', [NGOController::class, 'approve'])->name('ngos.approve');
    Route::get('/ngos/{id}', [NGOController::class, 'show'])->name('ngos.show');

    Route::get('/bills', [BillController::class, 'index'])->name('bills.index');
    Route::delete('/bills/{id}', [BillController::class, 'destroy'])->name('bills.delete');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/fund/store', [SettingController::class, 'store'])->name('fund.store');
    Route::post('/settings/update-initial-fund', [SettingController::class, 'updateInitialFund'])->name('settings.updateInitialFund');

    Route::put('/fund/{id}', [SettingController::class, 'update'])->name('fund.update');
    Route::delete('/fund/{id}', [SettingController::class, 'destroy'])->name('fund.destroy');

    Route::get('/send-test-mail', [SettingController::class, 'sendTestMail']);

});

