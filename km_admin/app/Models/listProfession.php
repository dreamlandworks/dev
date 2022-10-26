<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listProfession extends Model
{
    use HasFactory;

    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $table = 'list_profession';

    public function subcategoryDetails()
    {  
        return $this->belongsTo(SubCategory::class,'subcategory_id','id');

    }
    public function categoryDetails()
    {  
        return $this->belongsTo(Category::class,'category_id','id');
    }

}
