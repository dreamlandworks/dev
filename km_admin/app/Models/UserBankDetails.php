<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBankDetails extends Model
{
    use HasFactory;
    
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $table='user_bank_details';
    protected $fillable=[
    	'users_id  ',
    	'account_name',
    	'account_no',
    	'ifsc_code',
    	'bank_details_id '
    ];
}
