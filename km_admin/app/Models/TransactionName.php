<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionName extends Model
{
    use HasFactory;
    protected $table='transaction_name';

    protected $fillable=['name'];
}
