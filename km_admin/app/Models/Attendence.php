<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    use HasFactory;
    protected $table='attendence';
    protected $fillable=['emp_id','date','status','type_of_leave','reason'];
}
