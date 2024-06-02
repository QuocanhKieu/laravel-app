<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VouchersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vouchers = [
            ["code" => "VN10", "discountAmount" => 50000, "minPurchase" => 500000],
            ["code" => "VN20", "discountAmount" => 80000, "minPurchase" => 1000000],
            ["code" => "VN30", "discountAmount" => 100000, "minPurchase" => 1500000]
        ];

        foreach ($vouchers as $voucher) {
            DB::table('vouchers')->insert([
                'code' => $voucher['code'],
                'discountAmount' => $voucher['discountAmount'],
                'minPurchase' => $voucher['minPurchase'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
