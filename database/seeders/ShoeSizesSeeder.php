<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShoeSizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = [
            ['24.0', '38.5', '5.5', '6'],
            ['24.5', '39', '6', '6.5'],
            ['25.0', '40', '6', '7'],
            ['25.5', '40.5', '6.5', '7.5'],
            ['26.0', '41', '7', '8'],
            ['26.5', '42', '7.5', '8.5'],
            ['27.0', '42.5', '8', '9'],
            ['27.5', '43', '8.5', '9.5'],
            ['28.0', '44', '9', '10'],
            ['28.5', '44.5', '9.5', '10.5'],
            ['29.0', '45', '10', '11'],
            ['29.5', '45.5', '10.5', '11.5'],
            ['30.0', '46', '11', '12'],
        ];

        foreach ($sizes as $size) {
            $centimeters = $size[0] . 'cm';
            $vnSize = $size[1] . ' VN';
            $ukSize = $size[2] . ' UK';
            $usSize = $size[3] . ' US';

            $formattedSize = "$centimeters - $vnSize - $ukSize - $usSize";

            DB::table('shoe_sizes')->insert([
                'size' => $formattedSize,
            ]);
        }
    }
}
