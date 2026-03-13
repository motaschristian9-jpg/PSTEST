<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Timecard;
use Illuminate\Http\Request;

class ThirteenthMonthController extends Controller
{
    public function index(Request $request)
    {
        // Filters for display table
        $year = $request->year ?? now()->year;
        $employmentType = $request->employment_type ?? null;
        $paySchedule = $request->pay_schedule ?? null;

        $query = Employee::query();

        if ($employmentType)
            $query->where('employment_type', $employmentType);
        if ($paySchedule)
            $query->where('pay_schedule', $paySchedule);

        $employees = $query->get();

        return view('thirteenth_month.index', compact('employees', 'year', 'employmentType', 'paySchedule'));
    }

    public function printBulk(Request $request)
    {
        $year = $request->year ?? now()->year;
        $employees = Employee::all();

        $thirteenth = $employees->map(function ($emp) use ($year) {
            $totalPay = Timecard::where('employee_id', $emp->id)
                ->whereYear('date', $year)
                ->sum('overall_total');

            return [
                'employee' => $emp,
                'year' => $year,
                'thirteenth_month' => $totalPay / 12,
            ];
        });

        $companyName = "DCJ's Construction Services";

        return view('thirteenth_month.print_thirteenth', compact('thirteenth', 'companyName'));
    }

    public function printSelected(Request $request)
    {
        $year = $request->year ?? now()->year;
        $ids = $request->ids ? explode(',', $request->ids) : [];

        if (empty($ids)) {
            abort(400, "No employees selected");
        }

        $employees = Employee::whereIn('id', $ids)->get();

        $thirteenth = $employees->map(function ($emp) use ($year) {
            $totalPay = Timecard::where('employee_id', $emp->id)
                ->whereYear('date', $year)
                ->sum('overall_total');

            return [
                'employee' => $emp,
                'year' => $year,
                'thirteenth_month' => $totalPay / 12,
            ];
        });

        $companyName = "DCJ's Construction Services";

        return view('thirteenth_month.print_thirteenth', compact('thirteenth', 'companyName'));
    }
}