<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timecard;
use App\Models\Employee;

class TimecardController extends Controller
{
    public function index()
    {
        $timecards = Timecard::with('employee')->paginate(10);
        $employees = Employee::all();
        return view('timecards.index', compact('timecards', 'employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'day_type' => 'required|in:Regular,Holiday,Special Non-Working Day,Special Working Day,Rest Day',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i',
            'break_hours' => 'nullable|numeric|min:0',
        ]);

        // Fetch employee info
        $employee = Employee::find($request->employee_id);

        // Calculate hours, pay, OT, night diff based on your VBA rules
        $calc = $this->computePay(
            $employee,
            $request->day_type,
            $request->time_in,
            $request->time_out,
            $request->break_hours
        );

        $timecard = Timecard::create(array_merge($request->all(), $calc));
 
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Timecard recorded successfully!',
                'data' => $timecard->load('employee')
            ]);
        }
 
        return redirect()->route('timecards.index')->with('success', 'Timecard recorded successfully!');
    }

    public function edit(Timecard $timecard)
    {
        return response()->json($timecard);
    }

    public function update(Request $request, Timecard $timecard)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'day_type' => 'required|in:Regular,Holiday,Special Non-Working Day,Special Working Day,Rest Day',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i',
            'break_hours' => 'nullable|numeric|min:0',
        ]);

        $employee = Employee::find($request->employee_id);

        $calc = $this->computePay(
            $employee,
            $request->day_type,
            $request->time_in,
            $request->time_out,
            $request->break_hours
        );

        $timecard->update(array_merge($request->all(), $calc));

        return redirect()->route('timecards.index')->with('success', 'Timecard updated successfully!');
    }

    public function destroy(Timecard $timecard)
    {
        $timecard->delete();
        return redirect()->route('timecards.index')->with('success', 'Timecard deleted successfully!');
    }

    // -- Calculation logic based on VBA --
    private function computePay($employee, $dayType, $timeIn, $timeOut, $breakHours)
    {
        $breakHours = $breakHours ?? 0;
        $timeInObj = $timeIn ? strtotime($timeIn) : null;
        $timeOutObj = $timeOut ? strtotime($timeOut) : null;

        $totalHours = 0;
        $otHours = 0;
        $nightDiff = 0;

        if ($timeInObj && $timeOutObj) {
            if ($timeOutObj <= $timeInObj) $timeOutObj += 24*3600;
            $totalHours = ($timeOutObj - $timeInObj)/3600 - $breakHours;

            if ($totalHours > 8) {
                $otHours = $totalHours - 8;
                $totalHours = 8;
            }

            // Night diff 10% (10 PM - 6 AM)
            $nightStart = strtotime("22:00");
            $nightEnd = strtotime("06:00") + 24*3600;
            $nightDiff = max(0, min($timeOutObj, $nightEnd) - max($timeInObj, $nightStart))/3600 * 0.1;
        }

        $basicRate = $employee->basic_rate ?? 0;
        $dailyRate = $basicRate;
        $hourlyRate = $dailyRate / 8;

        $pay = 0;
        $totalOT = $otHours * $hourlyRate * 1.25;

        switch($dayType){
            case 'Regular':
                $pay = $hourlyRate * $totalHours;
                break;
            case 'Holiday':
                $pay = $employee->employment_type == 'Regular' ? $hourlyRate * $totalHours * 2 : $hourlyRate * $totalHours * 1.3;
                break;
            case 'Special Non-Working Day':
                $pay = $hourlyRate * $totalHours * 1.3;
                break;
            case 'Special Working Day':
                $pay = $hourlyRate * $totalHours * 1;
                break;
            case 'Rest Day':
                $pay = $hourlyRate * $totalHours * 1.3;
                break;
        }

        $overallTotal = $pay + $totalOT + ($hourlyRate * $nightDiff);

        return [
            'employee_name' => $employee->full_name,
            'total_hours' => $totalHours,
            'ot_hours' => $otHours,
            'night_diff_pay' => $nightDiff * $hourlyRate,
            'ot_pay' => $totalOT,
            'overall_total' => $overallTotal,
        ];
    }
}