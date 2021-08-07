<?php

namespace App\Http\Controllers;

class ProductCategoriesController extends Controller
{
    public function __invoke()
    {
        return view('product-categories.index');
    }
}
