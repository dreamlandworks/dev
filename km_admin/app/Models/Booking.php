<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $table = 'booking';

    protected $fillable = [
        'users_id','sp_id','category_id','time_slot_id','scheduled_date'
    ];

    public function userdetail()
    {
        return $this->belongsTo(UserDetails::class,'users_id','id');
    }
    public function spdetail()
    {
        return $this->belongsTo(UserDetails::class,'sp_id','id');
    }
}
