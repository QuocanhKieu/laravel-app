<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('order_code');
            $table->string('name');
            $table->string('phone_number');
            $table->string('email');
            $table->string('province_code')->charset('utf8')->collation('utf8_vietnamese_ci');
            $table->string('district_code')->charset('utf8')->collation('utf8_vietnamese_ci');
            $table->string('ward');
            $table->text('delivery_address_detail');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('order_code')->references('order_code')->on('orders')->onDelete('cascade');
            $table->foreign('province_code')->references('code')->on('provinces')->onDelete('cascade');
            $table->foreign('district_code')->references('code')->on('districts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
