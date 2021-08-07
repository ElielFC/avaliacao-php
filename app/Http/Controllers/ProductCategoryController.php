<?php

namespace App\Http\Controllers;

class ProductCategoryController extends Controller
{
    public function __invoke()
    {
        return view('product-category.index');
    }
}
