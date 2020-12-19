<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param string $customer_address_path
     * @return void
     */
    public function run($customer_address_path)
    {
        $content = file_get_contents($customer_address_path);
        $customer_address = json_decode($content, true);

        DB::table('customer_address')->insert($customer_address);
    }
}
