<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('name' , 100)->primary();
            $table->float('price');
            $table->float('weight');
            $table->string('shipped_from' , 10);
            $table->unsignedBigInteger('weight_class_id');
            $table->unsignedBigInteger('bundle_id')->nullable();
            $table->foreign('weight_class_id')
                ->references('id')
                ->on('weight_class');
            $table->foreign('bundle_id')
                ->references('id')
                ->on('products_bundle');
            $table->timestamps();
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
