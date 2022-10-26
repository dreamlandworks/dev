<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpPlan extends Model
{
    use HasFactory;
     protected $table = 'sp_plans';
        
    const UPDATED_AT = null;
    const CREATED_AT = null;
    
    protected $fillable = [
            'name','description','amount','period','premium_tag','platform_fee_per_booking','bids_per_month','sealed_bids_per_month','customer_support'
        ];
    
}
