<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Timecard;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        // Filters
        $start = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $end = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');
        $employmentType = $request->employment_type ?? null;
        $paySchedule = $request->pay_schedule ?? null;

        // Query employees that have timecards within the range
        $query = Employee::whereHas('timecards', function ($q) use ($start, $end) {
            $q->whereBetween('date', [$start, $end]);
        })->with([
                    'timecards' => function ($q) use ($start, $end) {
                        $q->whereBetween('date', [$start, $end]);
                    }
                ]);

        if ($employmentType) {
            $query->where('employment_type', $employmentType);
        }

        if ($paySchedule) {
            $query->where('pay_schedule', $paySchedule);
        }

        $employees = $query->get();

        // Compute payroll
        $payrolls = $employees->map(function ($emp) {
            return $emp->calculatePayroll();
        });

        return view('payroll.index', compact(
            'payrolls',
            'start',
            'end',
            'employmentType',
            'paySchedule'
        ));
    }


    public function printBulk(Request $request)
    {
        $start = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $end = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');

        $employees = Employee::whereHas('timecards', function ($q) use ($start, $end) {
            $q->whereBetween('date', [$start, $end]);
        })->with([
                    'timecards' => function ($q) use ($start, $end) {
                        $q->whereBetween('date', [$start, $end]);
                    }
                ])->get();

        $payrolls = $employees->map(function ($emp) {
            return $emp->calculatePayroll();
        });

        return view('payroll.print_payslip', compact('payrolls', 'start', 'end'));
    }


    public function printSelected(Request $request)
    {
        $ids = explode(',', $request->ids);

        $start = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $end = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');

        $employees = Employee::whereIn('id', $ids)
            ->with([
                'timecards' => function ($q) use ($start, $end) {
                    $q->whereBetween('date', [$start, $end]);
                }
            ])->get();

        $payrolls = $employees->map(function ($emp) {
            return $emp->calculatePayroll();
        });

        return view('payroll.print_payslip', compact('payrolls', 'start', 'end'));
    }
}