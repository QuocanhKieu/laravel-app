<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateSizesTableNameColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Change the data type of the `name` column to allow NULL values
        Schema::table('sizes', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
        });

        $oldsizeNames = [
            '24.0',
            '24.5',
            '25.0',
            '25.5',
            '26.0',
            '26.5',
            '27.0',
            '27.5',
            '28.0',
            '28.5',
            '29.0',
            '29.5',
            '30.0',
        ];
        // Update the column values
        $sizeNames = [
            '38.5',
            '39',
            '40',
            '40.5',
            '41',
            '42',
            '42.5',
            '43',
            '44',
            '44.5',
            '45',
            '45.5',
            '46',
        ];

        foreach ($oldsizeNames as $key => $oldsizeName) {
            DB::table('sizes')->where('name','Size'.' '.$oldsizeName)->update(['name' => 'Size ' . $sizeNames[$key]]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert the changes if needed
    }
}

