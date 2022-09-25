<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderedMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordered_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');

            $table->Integer('material_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('color',config('constants.colors'));
            $table->float('price', 10,2);
            $table->enum('unit',config('constants.units'));
            $table->float('quantity', 10, 4);

            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')
                ->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordered_materials');
    }
}
