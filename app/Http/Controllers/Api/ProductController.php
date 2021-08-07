<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Product\CreateProductService;
use App\Services\Product\ListProductService;
use App\Services\Product\UpdateProductService;
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

    public function __construct(
        ListProductService $list_products_service,
        CreateProductService $create_product_service,
        UpdateProductService $update_product_service
    ) {
        $this->list_products_service = $list_products_service;
        $this->create_product_service = $create_product_service;
        $this->update_product_service = $update_product_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->list_products_service->execute();
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

        $this->validate($request, [
            'product_category_id' => 'required|exists:product_categories,id',
            'registration_date' => 'required|date_format:Y-m-d',
            'product_name' => 'required|max:150',
            'product_value' => 'required|numeric',
        ]);

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
    public function show($id)
    {
        //
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
                'registration_date'   => 'required|date_format:Y-m-d',
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
    public function destroy($id)
    {
        //
    }
}
