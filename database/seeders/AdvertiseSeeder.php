<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdvertiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = array(
            array('imageUrl' => 'uploads/24/06/1718101787-963.png','status' => '1','created_at' => '2024-06-11 16:29:48','updated_at' => '2024-06-11 16:29:48'),
            array('imageUrl' => 'uploads/24/06/1718101799-395.png','status' => '1','created_at' => '2024-06-11 16:29:59','updated_at' => '2024-06-11 16:29:59'),
            array('imageUrl' => 'uploads/24/06/1718101807-972.png','status' => '1','created_at' => '2024-06-11 16:30:07','updated_at' => '2024-06-11 16:30:07')
        );

        Banner::insert($banners);
    }
}
