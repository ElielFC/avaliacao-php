<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('product_category_id');
            $table->date('registration_date');
            $table->string('product_name');
            $table->decimal('product_value', 10, 2);
            $table->timestamps();

            $table->foreign('product_category_id', 'fk_tb_products_tb_product_categories')->references('id')->on('product_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
