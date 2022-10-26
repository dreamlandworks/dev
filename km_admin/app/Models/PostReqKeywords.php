<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostReqKeywords extends Model
{
    use HasFactory;
    const UPDATED_AT = null;
    const CREATED_AT = null;
    
    protected $table ='post_req_keyword';

    protected $fillable = ['post_job_id','keywords_id'];
}
