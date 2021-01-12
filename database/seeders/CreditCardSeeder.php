<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreditCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($credit_card_path)
    {
        $content = file_get_contents($credit_card_path);
        $credit_card = json_decode($content, true);

        DB::table('credit_card')->insert($credit_card);
    }
}
