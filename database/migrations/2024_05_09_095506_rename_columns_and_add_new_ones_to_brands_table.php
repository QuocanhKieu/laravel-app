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
        Schema::table('brands', function (Blueprint $table) {
            // Rename columns
            $table->renameColumn('logo', 'logo_name');
            $table->renameColumn('banner', 'banner_name');

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            // Rename columns back to original names
            $table->renameColumn('logo_name', 'logo');
            $table->renameColumn('banner_name', 'banner');

            // Remove added columns
        });
    }

};
