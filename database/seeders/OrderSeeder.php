<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param string $order_path
     * @return void
     */
    public function run($order_path)
    {
        $content = file_get_contents($order_path);
        $order = json_decode($content, true);

        DB::table('order')->insert($order);
    }
}
