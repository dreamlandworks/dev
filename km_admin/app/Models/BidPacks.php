<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidPacks extends Model
{
    use HasFactory;
    protected $table="bid_packs";

    protected $fillable=['package_name','bids','amount','validity','deleted_at'];
}
