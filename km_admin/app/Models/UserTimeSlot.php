<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTimeSlot extends Model
{
    use HasFactory;

    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $table = 'user_time_slot';

    protected $fillable = [
        'users_id','day_slot','time_slot_id','time_slot_from','time_slot_to','availability_day'
    ];
}
