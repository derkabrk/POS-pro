<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = array(
            array('business_id' => '1','email' => 'shopowner@shopowner.com','name' => 'Trade G','role' => 'shop-owner','phone' => '3452534','image' => NULL,'lang' => 'en','visibility' => NULL,'password' => bcrypt('123456'),'status' => '1','email_verified_at' => NULL,'remember_token' => NULL,'created_at' => '2024-09-26 12:12:22','updated_at' => '2024-09-26 12:12:22')
        );

        User::insert($users);
    }
}
