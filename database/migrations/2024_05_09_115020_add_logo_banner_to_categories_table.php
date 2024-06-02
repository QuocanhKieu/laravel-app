<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogoBannerToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('logo_name')->nullable()->after('slug');
            $table->string('logo_path')->nullable()->after('logo_name');
            $table->string('logo_origin_name')->nullable()->after('logo_path');
            $table->string('banner_name')->nullable()->after('logo_origin_name');
            $table->string('banner_path')->nullable()->after('banner_name');
            $table->string('banner_origin_name')->nullable()->after('banner_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'logo_name',
                'logo_path',
                'logo_origin_name',
                'banner_name',
                'banner_path',
                'banner_origin_name',
            ]);
        });
    }
}

