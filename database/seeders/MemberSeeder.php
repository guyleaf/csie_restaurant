<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path('database/seeders/member.json');

        $content = file_get_contents($path);
        $member = json_decode($content, true);

        foreach ($member as $person) {
            DB::table('member')->insert([
                'id' => $person['id'],
                'name' => $person['name'],
                'username' => $person['username'],
                'password' => Hash::make($person['password']),
                'member_status' => $person['member_status'],
                'phone' => $person['phone'],
                'email' => $person['email'],
                'permission' => $person['permission'],
                'created_at' => $person['created_at'],
                'updated_at' => $person['updated_at']
            ]);
        }

        $path = base_path('database/seeders/customer.json');

        $content = file_get_contents($path);
        $customer = json_decode($content, true);

        foreach ($customer as $person) {
            DB::table('customer')->insert($person);
        }

        $path = base_path('database/seeders/seller.json');

        $content = file_get_contents($path);
        $seller = json_decode($content, true);

        foreach ($seller as $person) {
            DB::table('seller')->insert($person);
        }
    }
}
