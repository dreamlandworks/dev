<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SingleReschedule extends Model
{
    use HasFactory;
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $table='re_schedule';

    protected $fillable = ['reschedule_id ','booking_id','scheduled_date','scheduled_time_slot_id','rescheduled_date','rescheduled_time_slot_id','req_raised_by_id','status_id'];
}
