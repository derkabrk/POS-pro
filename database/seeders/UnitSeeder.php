<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = array(
            array('unitName' => 'kg','business_id' => '1','status' => '1','created_at' => '2024-11-05 09:55:24','updated_at' => '2024-11-05 09:55:24')
          );

        Unit::insert($units);
    }
}
