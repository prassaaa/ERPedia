<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Profile Settings
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Profile alias
    Route::redirect('profile', 'settings/profile')->name('profile.edit');

    // Company Management
    Route::prefix('companies')->name('companies.')->group(function () {
        Route::get('/', function () { return view('companies.index'); })->name('index');
        Route::get('/create', function () { return view('companies.create'); })->name('create');
        Route::get('/{company}', function () { return view('companies.show'); })->name('show');
        Route::get('/{company}/edit', function () { return view('companies.edit'); })->name('edit');
    });

    // Department Management
    Route::prefix('departments')->name('departments.')->group(function () {
        Route::get('/', function () { return view('departments.index'); })->name('index');
        Route::get('/create', function () { return view('departments.create'); })->name('create');
        Route::get('/{department}', function () { return view('departments.show'); })->name('show');
        Route::get('/{department}/edit', function () { return view('departments.edit'); })->name('edit');
    });

    // User/Employee Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', function () { return view('users.index'); })->name('index');
        Route::get('/create', function () { return view('users.create'); })->name('create');
        Route::get('/{user}', function (\App\Models\User $user) { return view('users.show', compact('user')); })->name('show');
        Route::get('/{user}/edit', function (\App\Models\User $user) { return view('users.edit', compact('user')); })->name('edit');
    });

    // Company Management
    Route::prefix('companies')->name('companies.')->group(function () {
        Route::get('/', function () { return view('companies.index'); })->name('index');
        Route::get('/create', function () { return view('companies.create'); })->name('create');
        Route::get('/{company}', function (\App\Models\Company $company) { return view('companies.show', compact('company')); })->name('show');
        Route::get('/{company}/edit', function (\App\Models\Company $company) { return view('companies.edit', compact('company')); })->name('edit');
    });

    // Department Management
    Route::prefix('departments')->name('departments.')->group(function () {
        Route::get('/', function () { return view('departments.index'); })->name('index');
        Route::get('/create', function () { return view('departments.create'); })->name('create');
        Route::get('/{department}', function (\App\Models\Department $department) { return view('departments.show', compact('department')); })->name('show');
        Route::get('/{department}/edit', function (\App\Models\Department $department) { return view('departments.edit', compact('department')); })->name('edit');
    });

    // Leave Management
    Route::prefix('leave-requests')->name('leave-requests.')->group(function () {
        Route::get('/', function () { return view('leave-requests.index'); })->name('index');
        Route::get('/create', function () { return view('leave-requests.create'); })->name('create');
        Route::get('/{leaveRequest}', function () { return view('leave-requests.show'); })->name('show');
        Route::get('/{leaveRequest}/edit', function () { return view('leave-requests.edit'); })->name('edit');
    });

    // Product Management
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', function () { return view('products.index'); })->name('index');
        Route::get('/create', function () { return view('products.create'); })->name('create');
        Route::get('/{product}', function () { return view('products.show'); })->name('show');
        Route::get('/{product}/edit', function () { return view('products.edit'); })->name('edit');
    });

    // Warehouse Management
    Route::prefix('warehouses')->name('warehouses.')->group(function () {
        Route::get('/', function () { return view('warehouses.index'); })->name('index');
        Route::get('/create', function () { return view('warehouses.create'); })->name('create');
        Route::get('/{warehouse}', function () { return view('warehouses.show'); })->name('show');
        Route::get('/{warehouse}/edit', function () { return view('warehouses.edit'); })->name('edit');
    });

    // Chart of Accounts
    Route::prefix('chart-of-accounts')->name('chart-of-accounts.')->group(function () {
        Route::get('/', function () { return view('chart-of-accounts.index'); })->name('index');
        Route::get('/create', function () { return view('chart-of-accounts.create'); })->name('create');
        Route::get('/{account}', function () { return view('chart-of-accounts.show'); })->name('show');
        Route::get('/{account}/edit', function () { return view('chart-of-accounts.edit'); })->name('edit');
    });
});

require __DIR__.'/auth.php';
