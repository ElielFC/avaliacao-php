<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * Listando todas as categorias
     *
     * @return void
     * @test
     */
    public function listAllProducts()
    {
        $this->actingAs(User::find(1));

        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
    }

    /**
     * Teste para criação de um novo produto
     *
     * @return void
     * @test
     */
    public function createProduct()
    {
        $this->actingAs(User::find(1));

        $product_category = factory(ProductCategory::class)->create();

        $product = factory(Product::class)->make([
            'product_category_id' => $product_category->id,
            'registration_date' => now()->format('Y-m-d'),
        ]);

        $response = $this->postJson('/api/products', $product->toArray());

        $response->assertStatus(201);

        $response->assertJson($product->toArray());
    }

    /**
     * Teste Falho para criação de um novo produto
     *
     * @return void
     * @test
     */
    public function failCreateProduct()
    {
        $this->actingAs(User::find(1));

        $product = factory(Product::class)->make([
            'product_category_id' => 20000,
            'registration_date' => now()->format('d-m-Y'),
        ]);

        $response = $this->postJson('/api/products', $product->toArray());

        $response->assertStatus(422);
    }

    /**
     * Teste para atualização um produto
     *
     * @return void
     * @test
     */
    public function updateProduct()
    {
        $this->actingAs(User::find(1));

        $product_category = factory(ProductCategory::class)->create();

        $product = factory(Product::class)->create([
            'product_category_id' => $product_category->id,
            'registration_date' => now()->format('Y-m-d'),
        ]);

        $response = $this->putJson('/api/products/'. $product->id, $product->toArray());

        $response->assertStatus(200);

        $response->assertJson($product->toArray());
    }

    /**
     * Teste Falho para atualiza um produto
     *
     * @return void
     * @test
     */
    public function failUpdateProduct()
    {
        $this->actingAs(User::find(1));

        $product = factory(Product::class)->create();

        $product->product_category_id = 20000;

        $response = $this->putJson('/api/products/' . $product->id, $product->toArray());

        $response->assertStatus(422);
    }

    /**
     * Excluindo um produto
     *
     * @return void
     * @test
     */
    public function destroyProduct()
    {
        $this->actingAs(User::find(1));

        $product = factory(Product::class)->create();

        $response = $this->deleteJson('/api/products/'. $product->id);

        $response->assertStatus(200);
    }

    /**
     * Falhar ao Excluir uma categoria
     *
     * @return void
     * @test
     */
    public function failDestroyProduct()
    {
        $this->actingAs(User::find(1));

        $response = $this->deleteJson('/api/products/'. 20000);

        $response->assertStatus(200);
    }
}
