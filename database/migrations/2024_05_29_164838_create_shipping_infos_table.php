<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingInfosTable extends Migration
{
    public function up()
    {
        Schema::create('shipping_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('order_code');
            $table->string('delivery_unit')->nullable();
            $table->string('delivery_code')->nullable();
            $table->string('delivery_method')->nullable();
            $table->integer('delivery_fee')->default(0);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('order_code')->references('order_code')->on('orders')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('shipping_infos');
    }
}
