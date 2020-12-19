<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellerCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param string $seller_category
     * @return void
     */
    public function run($seller_category_path)
    {
        $content = file_get_contents($seller_category_path);
        $seller_category = json_decode($content, true);

        DB::table('seller_category')->insert($seller_category);
    }
}
