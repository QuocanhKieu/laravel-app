<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameColumnToSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sizes', function (Blueprint $table) {
            // Add new column
            $table->string('name')->after('id')->nullable();

            // Rename existing column
            $table->renameColumn('size', 'content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sizes', function (Blueprint $table) {
            // Drop the new column
            $table->dropColumn('name');

            // Rename back to the original column name
            $table->renameColumn('content', 'size');
        });
    }
}
