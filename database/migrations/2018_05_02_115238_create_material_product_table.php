<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_product', function (Blueprint $table) {
            $table->integer('material_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->primary(['material_id', 'product_id']);
            $table->float('required',12,4);
            $table->timestamps();

            $table->foreign('material_id')
                ->references('id')
                ->on('materials');

            $table->foreign('product_id')
                ->references('id')
                ->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_product');
    }
}
