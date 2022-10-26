<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelieveLetter extends Model
{
    use HasFactory;
    protected $table="relieve_letter";

    protected $fillable=['employee_name','employee_id','department','designation','joining_date','date_of_relieving','resignation_letter','relieve_content'];
}
