<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;

    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $table = 'tariff';

    protected $fillable = [
        'per_hour','per_day','min_charges','extra_charge','users_id','profession_id'
    ];
}
