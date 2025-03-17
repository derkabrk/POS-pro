<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BusinessCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $business_categories = array(
            array('name' => 'Fashion Store','description' => NULL,'status' => 1,'created_at' => now(),'updated_at' => now()),
            array('name' => 'Electronics Store','description' => NULL,'status' => 1,'created_at' => now(),'updated_at' => now()),
            array('name' => 'Computer Store','description' => NULL,'status' => 1,'created_at' => now(),'updated_at' => now()),
            array('name' => 'Vegetable Store','description' => NULL,'status' => 1,'created_at' => now(),'updated_at' => now()),
            array('name' => 'Meat Store','description' => NULL,'status' => 1,'created_at' => now(),'updated_at' => now()),
            array('name' => 'BR','description' => NULL,'status' => 1,'created_at' => now(),'updated_at' => now()),
            array('name' => 'Restaurant','description' => NULL,'status' => 1,'created_at' => now(),'updated_at' => now()),
            array('name' => 'CAR WASH','description' => NULL,'status' => 1,'created_at' => now(),'updated_at' => now()),
        );

        BusinessCategory::insert($business_categories);
    }
}
