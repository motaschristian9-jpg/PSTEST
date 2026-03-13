<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThirteenthMonth extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'year',
        'thirteenth_month_amount',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}