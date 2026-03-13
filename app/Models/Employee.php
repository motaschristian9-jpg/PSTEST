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
        $grossPay = $timecards->sum('overall_total');

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
            'ot_pay' => $totalOT,
            'night_diff_pay' => $nightDiff,
            'gross_pay' => $grossPay,
            'total_deductions' => $totalDeductions,
            'net_pay' => $netPay,
        ];
    }
}