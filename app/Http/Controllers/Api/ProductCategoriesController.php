<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductCategories\{
    ListProductCategoriesService,
    CreateProductCategoriesService,
    UpdateProductCategoriesService,
    DeleteProductCategoriesService,
    ShowProductCategoriesService
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCategoriesController extends Controller
{
    /**
     * @var ListProductCategoriesService
     */
    private $list_product_categories_service;

    /**
     * @var CreateProductCategoriesService
     */
    private $create_product_category_service;

    /**
     * @var UpdateProductCategoriesService
     */
    private $update_product_category_service;

    /**
     * @var DeleteProductCategoriesService
     */
    private $delete_product_category_service;

    /**
     * @var ShowProductCategoriesService
     */
    private $show_product_category_service;

    public function __construct(
        ListProductCategoriesService $list_product_categories_service,
        CreateProductCategoriesService $create_product_category_service,
        UpdateProductCategoriesService $update_product_category_service,
        DeleteProductCategoriesService $delete_product_category_service,
        ShowProductCategoriesService $show_product_category_service
    ) {
        $this->list_product_categories_service = $list_product_categories_service;
        $this->create_product_category_service = $create_product_category_service;
        $this->update_product_category_service = $update_product_category_service;
        $this->delete_product_category_service = $delete_product_category_service;
        $this->show_product_category_service = $show_product_category_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_categories = $this->list_product_categories_service->execute();

        return response()->json($product_categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            'name_category' => 'required|max:150'
        ]);

        $attributes = $request->only(['name_category']);

        try {
            $product_category = $this->create_product_category_service->execute($attributes);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            abort(500, 'Internal Server Error');
        }

        DB::commit();

        return response()->json($product_category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        DB::beginTransaction();

        validator([
            'id' => $id
        ], [
            'id' => 'required|exists:product_categories,id',
        ])->validate();

        try {
            $product_category = $this->show_product_category_service->execute($id);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            abort(500, 'Internal Server Error');
        }

        DB::commit();

        return response()->json($product_category, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, Request $request)
    {
        DB::beginTransaction();

        validator([
            'id' => $id,
            'name_category' => $request->input('name_category')
        ], [
            'id' => 'required|exists:product_categories,id',
            'name_category' => 'required|max:150'
        ])->validate();

        $attributes = $request->only(['name_category']);

        try {
            $product_category = $this->update_product_category_service->execute($id, $attributes);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            abort(500, 'Internal Server Error');
        }

        DB::commit();

        return response()->json($product_category, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        DB::beginTransaction();

        try {
            $this->delete_product_category_service->execute($id);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            abort(500, 'Internal Server Error');
        }

        DB::commit();

        return response()->json([], 200);
    }
}
