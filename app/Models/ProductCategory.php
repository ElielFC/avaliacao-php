<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductCategory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'product_categories';

    protected $fillable = [
        'name_category',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }
}
