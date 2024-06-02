<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('sizes', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
        });

        // Update the name column by adding "Size" prefix to each value
        DB::table('sizes')->update(['name' => DB::raw('CONCAT("Size ", name)')]);
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Revert the update by removing "Size" prefix from each value
        DB::table('sizes')->update(['name' => DB::raw('SUBSTRING(name, 6)')]);

        Schema::table('sizes', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
        });
    }
};
