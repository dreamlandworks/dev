<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostJob extends Model
{
    use HasFactory;

    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $table = 'post_job';

    protected $fillable=[
    	'booking_id',
    	'user_plan_id',
    	'status_id',
    	'bids_period',
    	'title',
    	'bid_per',
    	'bid_range_id'
    	];
    	

    public function BookingDetails()
    {  
        return $this->belongsTo(Booking::class,'booking_id','id');
    }
    public function BidRange()
    {  
        return $this->belongsTo(BidRange::class,'bid_range_id','bid_range_id');
    }
    public function EstimateType()
    {  
        return $this->belongsTo(EstimateType::class,'bid_per','id');
    }
    public function BookingStatusCode()
    {  
        return $this->belongsTo(BookingStatusCode::class,'status_id','id');
    }
    
    
}
