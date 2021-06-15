<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'feature_image_name',
        'feature_image_path',
        'quantity',
        'price',
        'user_id'
    ];

    public function category(){
        return $this->belongsto(Category::class, 'category_id');
    }
}
