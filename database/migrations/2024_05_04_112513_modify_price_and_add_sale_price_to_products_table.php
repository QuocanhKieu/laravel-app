<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPriceAndAddSalePriceToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Add sale_price column before price
            $table->unsignedInteger('sale_price')->nullable()->after('name');

            // Modify price column to be unsigned integer
            $table->unsignedInteger('price')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop sale_price column
            $table->dropColumn('sale_price');

            // Modify price column to be integer
            $table->integer('price')->change();
        });
    }
}
