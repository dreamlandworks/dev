<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    use HasFactory;

    const UPDATED_AT = null;
    const CREATED_AT = null;
    
    protected $table="withdraw_request";

    protected $fillable=['created_on','users_id','amount','status','transaction_id','ubd_id'];
}
