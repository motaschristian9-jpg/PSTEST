<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date_from',
        'date_to',
        'pay_schedule',
        'employment_type',
        'gross_pay',
        'sss_amount',
        'hdmf_amount',
        'philhealth_amount',
        'other_deductions',
        'net_pay',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}