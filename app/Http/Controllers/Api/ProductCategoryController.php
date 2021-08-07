<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ProductCategoryWithProductsException;
use App\Http\Controllers\Controller;
use App\Services\ProductCategory\{
    ListProductCategoryService,
    CreateProductCategoryService,
    UpdateProductCategoryService,
    DeleteProductCategoryService,
    ShowProductCategoryService
};
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{
    /**
     * @var ListProductCategoryService
     */
    private $list_product_categories_service;

    /**
     * @var CreateProductCategoryService
     */
    private $create_product_category_service;

    /**
     * @var UpdateProductCategoryService
     */
    private $update_product_category_service;

    /**
     * @var DeleteProductCategoryService
     */
    private $delete_product_category_service;

    /**
     * @var ShowProductCategoryService
     */
    private $show_product_category_service;

    public function __construct(
        ListProductCategoryService $list_product_categories_service,
        CreateProductCategoryService $create_product_category_service,
        UpdateProductCategoryService $update_product_category_service,
        DeleteProductCategoryService $delete_product_category_service,
        ShowProductCategoryService $show_product_category_service
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
        } catch (ProductCategoryWithProductsException $e) {
            DB::rollBack();
            abort(403, $e->getMessage());
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            abort(404, $e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            abort(500, 'Internal Server Error');
        }

        DB::commit();

        return response()->json([], 200);
    }
}
