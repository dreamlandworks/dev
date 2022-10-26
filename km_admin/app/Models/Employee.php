<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table='employee';

    protected $fillable=[
    	'name',
        'father_name',
        'date_of_birth',
        'gender',
        'mobile_no',
        'local_address',
        'permanent_address',
        'photo',
        'email',
        'password',
        'employee_id',
        'date_of_joining',
        'department',
        'designation',
        'joining_salery',
        'account_holder_name',
        'account_number',
        'bank_name',
        'ifsc_code',
        'pan_number',
        'branch',
        'document_path',
        'resume',
        'offer_letter',
        'joining_letter',
        'contract_and_agreement',
        'id_proof'
    	];
}
