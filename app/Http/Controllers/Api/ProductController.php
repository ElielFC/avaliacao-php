<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Services\Product\{
    CreateProductService,
    DeleteProductService,
    ListProductService,
    ShowProductService,
    UpdateProductService
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * @var ListProductService
     */
    private $list_products_service;

    /**
     * @var CreateProductService
     */
    private $create_product_service;

    /**
     * @var UpdateProductService
     */
    private $update_product_service;

    /**
     * @var DeleteProductService
     */
    private $delete_product_service;

    /**
     * @var ShowProductService
     */
    private $show_product_service;

    public function __construct(
        ListProductService $list_products_service,
        CreateProductService $create_product_service,
        UpdateProductService $update_product_service,
        DeleteProductService $delete_product_service,
        ShowProductService $show_product_service
    ) {
        $this->list_products_service = $list_products_service;
        $this->create_product_service = $create_product_service;
        $this->update_product_service = $update_product_service;
        $this->delete_product_service = $delete_product_service;
        $this->show_product_service = $show_product_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->list_products_service->execute(
            request()
                ->only(['product_name', 'product_category_id'])
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        DB::beginTransaction();

        $attributes = $request->only([
            'product_category_id',
            'registration_date',
            'product_name',
            'product_value',
        ]);

        try {
            $product = $this->create_product_service->execute($attributes);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            abort(500, 'Internal Server Error');
        }

        DB::commit();

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return $this->show_product_service->execute($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, Request $request)
    {
        DB::beginTransaction();

        validator(
            [
                'id'                  => $id,
                'product_category_id' => $request->input('product_category_id'),
                'registration_date'   => $request->input('registration_date'),
                'product_name'        => $request->input('product_name'),
                'product_value'       => $request->input('product_value'),
            ],
            [
                'id'                  => 'required|exists:products,id',
                'product_category_id' => 'required|exists:product_categories,id',
                'registration_date' => 'required|date_format:Y-m-d H:i:s',
                'product_name'        => 'required|max:150',
                'product_value'       => 'required|numeric',
            ]
        )->validate();

        $attributes = $request->only([
            'product_category_id',
            'registration_date',
            'product_name',
            'product_value',
        ]);

        try {
            $product = $this->update_product_service->execute($id, $attributes);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            abort(500, 'Internal Server Error');
        }

        DB::commit();

        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        DB::beginTransaction();

        try {
            $this->delete_product_service->execute($id);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            abort(500, 'Internal Server Error');
        }

        DB::commit();

        return response()->json([], 200);
    }
}
