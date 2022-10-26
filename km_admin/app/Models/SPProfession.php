<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPProfession extends Model
{
    use HasFactory;
    
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $table = 'sp_profession';

    protected $fillable = [
        'users_id','profession_id','exp_id'
    ];
}
