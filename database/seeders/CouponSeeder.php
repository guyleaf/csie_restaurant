<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param string $coupon_path
     * @return void
     */
    public function run($coupon_path)
    {
        $content = file_get_contents($coupon_path);
        $coupon = json_decode($content, true);

        DB::table('coupon')->insert($coupon);
    }
}
