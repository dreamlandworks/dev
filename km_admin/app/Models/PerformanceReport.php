<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceReport extends Model
{
    use HasFactory;
    protected $table='performance_report';

    protected $fillable = [
        'employee_name',
        'employee_id',
        'department',
        'designation',
        'joining_date',
        'period_from',
        'period_to',
        'reviewer_name',
        'date_of_review',
        'preformance_in_brief',
        'work_to_full_potential',
        'communication',
        'productivity',
        'punctuality',
        'attendence',
        'technical_Skills',
        'deleted_at'
    ];
}
