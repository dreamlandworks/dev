<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class skill extends Model
{
    use HasFactory;

    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $table = 'keywords';

    public function professionDetails()
    {  
        return $this->belongsTo(listProfession::class,'profession_id','id');
    }
}
