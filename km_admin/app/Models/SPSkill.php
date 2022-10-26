<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPSkill extends Model
{
    use HasFactory;

    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $table = 'sp_skill';

    protected $fillable = [
        'users_id','keywords_id','profession_id'
    ];
}
