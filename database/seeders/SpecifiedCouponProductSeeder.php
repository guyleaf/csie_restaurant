<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecifiedCouponProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param string $specified_coupon_product_path
     * @return void
     */
    public function run($specified_coupon_product_path)
    {
        $content = file_get_contents($specified_coupon_product_path);
        $specified_coupon_product = json_decode($content, true);

        DB::table('specified_coupon_product')->insert($specified_coupon_product);
    }
}
