<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
{
    use HasFactory;

    protected $table = 'user_plans';
        
    const UPDATED_AT = null;
    const CREATED_AT = null;
    
    protected $fillable = [
            'name','description','amount','period','premium_tag','posts_per_month','proposals_per_post','customer_support'
        ];

}
