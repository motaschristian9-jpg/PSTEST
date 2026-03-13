<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    EmployeeController,
    TimecardController,
    PayrollController,
    ThirteenthMonthController
};

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Resource routes
    Route::resource('employees', EmployeeController::class);
    Route::resource('timecards', TimecardController::class);
    Route::resource('payrolls', PayrollController::class);
    Route::resource('thirteenth_month', ThirteenthMonthController::class);

    // Named routes for printing
    Route::get('/payroll/print-bulk', [PayrollController::class, 'printBulk'])
        ->name('payrolls.printBulk');

    Route::get('/payroll/print-selected', [PayrollController::class, 'printSelected'])
        ->name('payrolls.printSelected');

    Route::get('/thirteenth-month/print-bulk', [ThirteenthMonthController::class, 'printBulk'])
        ->name('thirteenth_month.printBulk');

    Route::get('/thirteenth-month/print-selected', [ThirteenthMonthController::class, 'printSelected'])
        ->name('thirteenth_month.printSelected');
});
