<?php

namespace Database\Seeders;

use App\Models\Vat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vats = array(
            array('name' => 'vat 1','business_id' => '1','rate' => '5','sub_vat' => NULL,'status' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'vat 2','business_id' => '1','rate' => '10','sub_vat' => NULL,'status' => '1','created_at' => now(),'updated_at' => now())
        );
        Vat::insert($vats);

    }
}
