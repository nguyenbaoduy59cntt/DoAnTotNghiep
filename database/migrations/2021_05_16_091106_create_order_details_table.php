<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            
        $table->string('productID',255);
        $table->string('orderID',255);

        //FOREIGN KEY CONSTRAINTS
        $table->foreign('productID')->references('productID')->on('products')->onDelete('cascade');
        $table->foreign('orderID')->references('orderID')->on('orders')->onDelete('cascade');
     
        //SETTING THE PRIMARY KEYS
        $table->primary(['productID','orderID']);

        $table->string('quantityPerUnit',255);
        $table->float('unitPrice',11,2);
        $table->float('discount',11,2);
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
        Schema::dropIfExists('order_details');
    }
}
