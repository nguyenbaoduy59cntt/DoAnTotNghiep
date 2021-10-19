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
            // $table->id();
            $table->string('productID',255)->primary('productID');
            $table->string('productName',255);
            $table->string('productImage',255);
            $table->string('unit',255);
            $table->float('unitPrice',11,2);
            $table->longText('description');
            $table->integer('maximum_stock_date');
            $table->integer('minimum_stock_quantity');
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
