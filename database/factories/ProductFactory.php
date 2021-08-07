<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use App\Models\ProductCategory;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'product_category_id' => factory(ProductCategory::class),
        'registration_date' => $faker->dateTimeBetween('-1 years', 'now'),
        'product_name' => $faker->name,
        'product_value' => $faker->randomFloat(2, 0, 1000),
    ];
});
