<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryBrandTable extends Migration
{
    public function up()
    {
        Schema::create('category_brand', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('brand_id')->constrained();
            $table->timestamps();
            $table->softDeletes(); // Add soft deletes column
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_brand');
    }
}
