<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyBrandsTable extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
public function up()
{
Schema::table('brands', function (Blueprint $table) {
// Remove the existing 'image' column
$table->dropColumn('image');

// Add new 'logo' and 'banner' columns
$table->string('logo')->nullable()->after('name');
$table->string('banner')->nullable()->after('logo');
});
}

/**
* Reverse the migrations.
*
* @return void
*/
public function down()
{
Schema::table('brands', function (Blueprint $table) {
// Reverse the changes made in the 'up' method
$table->string('image')->nullable()->after('name');
$table->dropColumn(['logo', 'banner']);
});
}
}
