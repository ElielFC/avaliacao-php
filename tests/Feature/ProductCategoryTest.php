<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Tests\TestCase;

class ProductCategoryTest extends TestCase
{
    /**
     * Listando todas as categorias
     *
     * @return void
     * @test
     */
    public function listAllProductCategories()
    {
        $this->actingAs(User::find(1));

        $response = $this->getJson('/api/product-categories');

        $response->assertStatus(200);
    }

    /**
     * Criando uma nova categoria
     *
     * @return void
     * @test
     */
    public function createProductCategory()
    {
        $this->actingAs(User::find(1));

        $categories = factory(ProductCategory::class)->make();

        $response = $this->postJson('/api/product-categories', [
            'name_category' => $categories->name_category,
        ]);

        $response->assertStatus(201);

        $response->assertJson([
            'name' => $categories->name_category,
        ]);
    }

    /**
     * Falhando ao criar uma nova categoria
     *
     * @return void
     * @test
     */
    public function failCreateProductCategory()
    {
        $this->actingAs(User::find(1));

        $response = $this->postJson('/api/product-categories', [
            'name_category' => '',
        ]);

        $response->assertStatus(422);
    }

    /**
     * Atualizando uma categoria
     *
     * @return void
     * @test
     */
    public function updateProductCategory()
    {
        $this->actingAs(User::find(1));

        $categories = factory(ProductCategory::class)->create();

        $response = $this->putJson('/api/product-categories/'. $categories->id, [
            'name_category' => $categories->name_category . 'Atualizado',
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'name' => $categories->name_category . 'Atualizado',
        ]);
    }

    /**
     * Falhar ao atualizar uma categoria
     *
     * @return void
     * @test
     */
    public function failUpdateProductCategory()
    {
        $this->actingAs(User::find(1));

        $categories = factory(ProductCategory::class)->create();

        $response = $this->putJson('/api/product-categories/'. $categories->id, [
            'name_category' => '',
        ]);

        $response->assertStatus(422);
    }

    /**
     * Falhar ao atualizar uma categoria inexistente
     *
     * @return void
     * @test
     */
    public function failUpdateProductCategoryNoExistent()
    {
        $this->actingAs(User::find(1));

        $response = $this->putJson('/api/product-categories/'. 200000, [
            'name_category' => 'teste',
        ]);

        $response->assertStatus(404);
    }

    /**
     * Excluindo uma categoria
     *
     * @return void
     * @test
     */
    public function destroyProductCategory()
    {
        $this->actingAs(User::find(1));

        $categories = factory(ProductCategory::class)->create();

        $response = $this->deleteJson('/api/product-categories/'. $categories->id);

        $response->assertStatus(200);
    }

    /**
     * Falhar ao Excluir uma categoria
     *
     * @return void
     * @test
     */
    public function failDestroyProductCategory()
    {
        $this->actingAs(User::find(1));

        $response = $this->deleteJson('/api/product-categories/'. 20000);

        $response->assertStatus(404);
    }

    /**
     * Falhar ao Excluir uma categoria associada a um produto
     *
     * @return void
     * @test
     */
    public function failDestroyProductCategoryWithProducts()
    {
        $this->actingAs(User::find(1));

        $category = factory(ProductCategory::class)->create();

        factory(Product::class, 2)->create([
            'product_category_id' => $category->id,
        ]);

        $response = $this->deleteJson('/api/product-categories/'. $category->id);

        $response->assertStatus(403);
    }
}
