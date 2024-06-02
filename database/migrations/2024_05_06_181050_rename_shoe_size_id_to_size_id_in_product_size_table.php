<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameShoeSizeIdToSizeIdInProductSizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_size', function (Blueprint $table) {
            $table->renameColumn('shoe_size_id', 'size_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_size', function (Blueprint $table) {
            $table->renameColumn('size_id', 'shoe_size_id');
        });
    }
}
