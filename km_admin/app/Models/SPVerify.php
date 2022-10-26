<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPVerify extends Model
{
    use HasFactory;
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $table = 'sp_verify';

    protected $fillable = [
        'id_card','video_record_1','video_record_2','video_record_3','video_record_4','users_id'
    ];

    // protected $append = ['fullimage'];

    // public function getIdCardAttribute()
    // {
    //     if($this->id_card != null){
    //         $id_proof = $this->id_proof;
    //         return URL('/id_proof/').'/'.$id_proof;
    //     }else{
    //         return URL('/id_proof/').'/defaultImage.png';
    //     }
    // }
}
