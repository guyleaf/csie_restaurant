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
    public function run($member_path, $customer_path, $seller_path)
    {
        $member = file_get_contents($member_path);
        $customer = file_get_contents($customer_path);
        $seller = file_get_contents($seller_path);

        $member = json_decode($member, true);
        $customer = json_decode($customer, true);
        $seller = json_decode($seller, true);

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

        foreach ($customer as $person) {
            DB::table('customer')->insert($person);
        }

        foreach ($seller as $person) {
            DB::table('seller')->insert($person);
        }
    }
}
