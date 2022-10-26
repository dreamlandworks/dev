<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table='ticket';

    protected $fillable=['present_status','assign_person','priority','created_date','created_by','description'];
}
