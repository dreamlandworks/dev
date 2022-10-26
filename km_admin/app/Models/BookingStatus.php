<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingStatus extends Model
{
    use HasFactory;
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $table='booking_status';

    protected $fillable = ['booking_id','status_id','sp_id'];
}
