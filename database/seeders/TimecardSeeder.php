<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Timecard;
use App\Models\Employee;
use Carbon\Carbon;

class TimecardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();
        $startDate = Carbon::now()->subDays(14);
        
        foreach ($employees as $employee) {
            for ($i = 0; $i < 14; $i++) {
                $date = $startDate->copy()->addDays($i);
                
                // Skip Sundays as Rest Day (or you can seed them as Rest Day with 0 hours)
                if ($date->isSunday()) {
                    continue;
                }

                $dayType = 'Regular';
                $timeIn = '08:00';
                $timeOut = '17:00'; // Default 9 hours (8 hours work + 1 hour break)
                $breakHours = 1.00;

                // Add some variety (Random OT or early out)
                $rand = rand(1, 10);
                if ($rand > 8) {
                    $timeOut = '19:00'; // 2 hours OT
                } elseif ($rand < 2) {
                    $timeOut = '16:00'; // 1 hour less
                }

                $calc = $this->calculatePay($employee, $dayType, $timeIn, $timeOut, $breakHours);
                
                Timecard::create([
                    'employee_id' => $employee->id,
                    'date' => $date->toDateString(),
                    'day_type' => $dayType,
                    'time_in' => $timeIn,
                    'time_out' => $timeOut,
                    'break_hours' => $breakHours,
                    'night_diff_pay' => $calc['night_diff_pay'],
                    'total_hours' => $calc['total_hours'],
                    'ot_hours' => $calc['ot_hours'],
                    'ot_pay' => $calc['ot_pay'],
                    'overall_total' => $calc['overall_total'],
                ]);
            }
        }
    }

    private function calculatePay($employee, $dayType, $timeIn, $timeOut, $breakHours)
    {
        $timeInObj = strtotime($timeIn);
        $timeOutObj = strtotime($timeOut);
        if ($timeOutObj <= $timeInObj) $timeOutObj += 24*3600;

        $totalHours = ($timeOutObj - $timeInObj)/3600 - $breakHours;
        $otHours = 0;

        if ($totalHours > 8) {
            $otHours = $totalHours - 8;
            $totalHours = 8;
        }

        // Night diff 10% (10 PM - 6 AM)
        $nightStart = strtotime("22:00");
        $nightEnd = strtotime("06:00") + 24*3600;
        $nightDiffSeconds = max(0, min($timeOutObj, $nightEnd) - max($timeInObj, $nightStart));
        $nightDiff = ($nightDiffSeconds / 3600) * 0.1;

        $dailyRate = $employee->basic_rate ?? 0;
        $hourlyRate = $dailyRate / 8;

        $totalOT = $otHours * $hourlyRate * 1.25;
        $pay = $hourlyRate * $totalHours;

        $overallTotal = $pay + $totalOT + ($hourlyRate * $nightDiff);

        return [
            'total_hours' => $totalHours,
            'ot_hours' => $otHours,
            'night_diff_pay' => $nightDiff * $hourlyRate,
            'ot_pay' => $totalOT,
            'overall_total' => $overallTotal,
        ];
    }
}
