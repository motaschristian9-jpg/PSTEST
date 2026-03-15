<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'employment_type',
        'designation',
        'hdmf_number',
        'sss_number',
        'philhealth_number',
        'basic_rate',
        'sss_amount',
        'hdmf_amount',
        'philhealth_amount',
        'other_deductions',
        'pay_schedule',
        'allowance',
        'accommodation',
        'load_allowance',
        'travel_allowance',
    ];

    // Relationships
    public function timecards()
    {
        return $this->hasMany(Timecard::class, 'employee_id');
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'employee_id');
    }

    public function thirteenthMonths()
    {
        return $this->hasMany(ThirteenthMonth::class, 'employee_id');
    }

    /**
     * Calculate the employee's payroll based on their timecards relationship.
     * Ensure timecards are pre-filtered by date before calling this.
     */
    public function calculatePayroll()
    {
        $timecards = $this->timecards;

        $totalHours = $timecards->sum('total_hours');
        $totalOTHours = $timecards->sum('ot_hours');
        $totalOT = $timecards->sum('ot_pay');
        $nightDiff = $timecards->sum('night_diff_pay');
        $timecardGross = $timecards->sum('overall_total');
        $basicPay = $timecardGross - $totalOT - $nightDiff;

        $allowance = $this->allowance ?? 0;
        $accommodation = $this->accommodation ?? 0;
        $loadAllowance = $this->load_allowance ?? 0;
        $travelAllowance = $this->travel_allowance ?? 0;
        $totalAllowances = $allowance + $accommodation + $loadAllowance + $travelAllowance;

        $grossPay = $timecardGross + $totalAllowances;

        $sss = $this->sss_amount ?? 0;
        $philhealth = $this->philhealth_amount ?? 0;
        $hdmf = $this->hdmf_amount ?? 0;
        $other = $this->other_deductions ?? 0;

        $totalDeductions = $sss + $philhealth + $hdmf + $other;
        $netPay = $grossPay - $totalDeductions;

        return [
            'employee' => $this,
            'total_hours' => $totalHours,
            'total_ot_hours' => $totalOTHours,
            'basic_pay' => $basicPay,
            'ot_pay' => $totalOT,
            'night_diff_pay' => $nightDiff,
            'allowance' => $allowance,
            'accommodation' => $accommodation,
            'load_allowance' => $loadAllowance,
            'travel_allowance' => $travelAllowance,
            'gross_pay' => $grossPay,
            'total_deductions' => $totalDeductions,
            'net_pay' => $netPay,
        ];
    }
}