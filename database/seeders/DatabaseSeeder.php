<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\MemberSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MemberSeeder::class);
    }
}
