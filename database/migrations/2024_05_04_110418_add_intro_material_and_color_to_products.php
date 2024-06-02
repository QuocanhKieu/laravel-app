<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Add intro column
            $table->text('intro')->nullable()->after('content');

            // Add material column
            $table->string('material')->nullable()->after('intro');

            // Add color column
            $table->string('color')->nullable()->after('material');
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
            // Drop intro column
            $table->dropColumn('intro');

            // Drop material column
            $table->dropColumn('material');

            // Drop color column
            $table->dropColumn('color');
        });
    }
};
