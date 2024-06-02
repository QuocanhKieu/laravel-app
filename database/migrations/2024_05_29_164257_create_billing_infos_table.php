<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingInfosTable extends Migration
{
    public function up()
    {
        Schema::create('billing_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('order_code');
            $table->text('billing_account_info');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('order_code')->references('order_code')->on('orders')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('billing_infos');
    }
}
