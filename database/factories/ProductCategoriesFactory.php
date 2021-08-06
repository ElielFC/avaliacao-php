<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProductCategories;
use Faker\Generator as Faker;

$factory->define(ProductCategories::class, function (Faker $faker) {
    return [
        'name_category' => $faker->word,
    ];
});
