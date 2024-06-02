<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->string('logo_path')->nullable()->after('logo_name');
            $table->string('logo_origin_name')->nullable()->after('logo_path');
            $table->string('banner_path')->nullable()->after('banner_name');
            $table->string('banner_origin_name')->nullable()->after('banner_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['logo_path', 'logo_origin_name', 'banner_path', 'banner_origin_name']);

        });
    }
};
