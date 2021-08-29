<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'products';

    protected $fillable = [
        'product_category_id',
        'registration_date',
        'product_name',
        'product_value'
    ];

    protected $casts = [
        'product_value' => 'float'
    ];

    public function productCategory()
    {
        return $this->hasOne(ProductCategory::class, 'id', 'product_category_id');
    }

    public function scopeProductCategoryName($query)
    {
        return $query->addSelect([
            'product_category_name' => ProductCategory::select('name_category')
                ->whereColumn('product_categories.id', 'products.product_category_id')
                ->limit(1)
        ]);
    }

}
