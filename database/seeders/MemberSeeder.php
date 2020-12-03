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
        // DB::insert('insert into "member" ("name", username, "password", member_status,
        // phone, email, "permission", created_at, updated_at)
        // values ("test", "csie", "csie", 0, "0906111111", "test@ggg.com", 0, "2020-12-04", "2020-12-04")');
        $cc = DB::table('member')->insert([
            'name' => 'test',
            'username' => 'csie',
            'password' => Hash::make('csie'),
            'member_status' => 1,
            'phone' => '0906111111',
            'email' => 'test@ggg.com',
            'permission' => 1,
            'created_at' => '2020-12-04',
            'updated_at' => '2020-12-04'
        ]);
    }
}
