<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param string $product_image_path
     * @return void
     */
    public function run($product_image_path)
    {
        $content = file_get_contents($product_image_path);
        $product_image = json_decode($content, true);

        DB::table('product_image')->insert($product_image);
    }
}
