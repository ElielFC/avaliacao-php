<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_categories';

    protected $fillable = [
        'name_category',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }
}
