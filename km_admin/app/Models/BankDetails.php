<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetails extends Model
{
    use HasFactory;

	const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $table='bank_details';

    protected $fillable=['ifsc_code','micr','bank','branch','bank_address','city','district','state'];
}
