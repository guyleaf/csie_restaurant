<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellerCategoryListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param string $seller_category_list_path
     * @return void
     */
    public function run($seller_category_list_path)
    {
        $content = file_get_contents($seller_category_list_path);
        $seller_category_list = json_decode($content, true);

        DB::table('seller_category_list')->insert($seller_category_list);
    }
}
