<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param string $product_path
     * @return void
     */
    public function run($product_path)
    {
        $content = file_get_contents($product_path);
        $product = json_decode($content, true);

        DB::table('product')->insert($product);
    }
}
