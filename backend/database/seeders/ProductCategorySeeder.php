<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param string $product_category_path
     * @return void
     */
    public function run($product_category_path)
    {
        $content = file_get_contents($product_category_path);
        $product_category = json_decode($content, true);

        DB::table('product_category')->insert($product_category);
    }
}
