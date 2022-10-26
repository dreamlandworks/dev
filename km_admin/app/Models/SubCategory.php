<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $table = 'subcategories';

    protected $fillable = [
        'sub_name','image','category_id','status'
    ];

    public function categoryDetails()
    {  
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
