<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Timecard;
use App\Models\Payroll;
use App\Models\ThirteenthMonth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();
        $todayTimecards = Timecard::whereDate('date', Carbon::today())->count();
        
        // Total Payroll net pay for the current month
        $totalPayrollMonth = Payroll::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('net_pay');
            
        // Number of employees who received 13th month pay this year
        $thirteenthMonthPaid = ThirteenthMonth::where('year', Carbon::now()->year)->count();

        // Recent activity lists
        $recentTimecards = Timecard::with('employee')->latest()->take(5)->get();
        $recentPayrolls = Payroll::with('employee')->latest()->take(5)->get();
        $newEmployees = Employee::latest()->take(5)->get();

        // Employment type breakdown
        $employmentTypes = Employee::select('employment_type', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('employment_type')
            ->get();

        return view('dashboard', compact(
            'totalEmployees',
            'todayTimecards',
            'totalPayrollMonth',
            'thirteenthMonthPaid',
            'recentTimecards',
            'recentPayrolls',
            'newEmployees',
            'employmentTypes'
        ));
    }
}
