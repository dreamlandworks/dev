<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

       const UPDATED_AT = null;
        const CREATED_AT = null;

    protected $table='transaction';

    protected $fillable = [
    	'name_id',
    	'date',
    	'amount',
    	'type_id',
    	'user_id',
    	'method_id',
    	'reference_id',
    	'order_id',
    	'booking_id',
    	'payment_status'
    ];
}
