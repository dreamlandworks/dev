<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketStatistics extends Model
{
    use HasFactory;
    protected $table='market_statistice';
    protected $fillable = [
        'name_of_ad_campaign',
        'leades_generated',
        'ends_in',
        'leads_converted',
        'projected_budget',
        'expenditure_till_date',
        'cac',
        'deleted_at'
    ];
}
