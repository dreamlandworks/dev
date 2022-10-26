<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class timeSlot extends Model
{
    use HasFactory;

    const UPDATED_AT = null;
    const CREATED_AT = null;
    
    protected $table = 'time_slot';
}
