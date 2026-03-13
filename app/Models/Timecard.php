<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timecard extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'day_type', // Regular, Holiday, Special Non-Working Day, Special Working Day, Rest Day
        'time_in',
        'time_out',
        'break_hours',
        'night_diff_pay',
        'total_hours',
        'ot_hours',
        'ot_pay',
        'overall_total',
    ];

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}