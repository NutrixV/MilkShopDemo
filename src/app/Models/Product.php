<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
    ];
    
    /**
     * Get the category that the product belongs to
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
