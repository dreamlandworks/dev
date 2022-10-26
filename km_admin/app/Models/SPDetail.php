<?php

namespace App\Models;
use App\Models\UserDetails;
use App\Models\User;
use DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPDetail extends Model
{
    use HasFactory;

    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $table = 'sp_det';

    protected $fillable = [
        'users_id','profession_id','qual_id','exp_id','about_me','availability_day'
    ];

    public function userinfo()
    {
        return $this->belongsTo(UserDetails::class,'users_id','id');
    }

    public function useremail()
    {
        return $this->belongsTo(User::class,'users_id','users_id');
    }

    // public static function Get_CityName($users_id = null){
    //     $city =  DB::select('SELECT TOP city FROM city
    //     JOIN address on address.city_id=city.id
    //     WHERE address.users_id='.$users_id);


    //     return $city;
    // }
}
