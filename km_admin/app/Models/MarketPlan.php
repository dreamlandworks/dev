<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketPlan extends Model
{

    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name_of_ad_campaign',
        'period',
        'campaign_type',
        'target_age_group',
        'gender',
        'date_of_start',
        'targeted_user_group',
        'budget_estimated',
        'content',
        'status',
        'document_path',
        'attachment',
        'deleted_at'
    ];
}
