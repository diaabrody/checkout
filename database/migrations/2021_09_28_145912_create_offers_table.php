<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('product_name' , 100)->nullable();
            $table->integer('quantity')->default(1);
            $table->string('related_product',100)->nullable();
            $table->integer('discount');
            $table->integer('bundle_id')->nullable();
            $table->foreign('product_name')
                ->references('name')
                ->on('products');
            $table->foreign('related_product')
                ->references('name')
                ->on('products');
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
        Schema::dropIfExists('offers');
    }
}
