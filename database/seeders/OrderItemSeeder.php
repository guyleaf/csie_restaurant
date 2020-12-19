<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param string $order_item_path
     * @return void
     */
    public function run($order_item_path)
    {
        $content = file_get_contents($order_item_path);
        $order_item = json_decode($content, true);

        DB::table('order_item')->insert($order_item);
    }
}
