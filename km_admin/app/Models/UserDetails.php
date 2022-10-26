<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Authenticatable
{
    use HasFactory, HasFactory, Notifiable;
    use HasRoles;
    
         const UPDATED_AT = null;
         const CREATED_AT = null;


            protected $table = 'user_details';

    
    protected $fillable = [
            'fname','lname','mobile','dob','gender','profile_pic','registered_on','referral_id'
        ];
        
   
     public function getEmailAttribute()
    {   
        
       $id = $this->attributes['email'];  
    //   dd($id);
       if($id)
       {   
           
           $this->attributes['email'] = "email not provided";
           
       }
       else
       {
           return $this->attributes['email'];
       }
    } 
    
    
}
