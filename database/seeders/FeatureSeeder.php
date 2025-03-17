<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = array(
            array('title' => 'Inventory Sales','bg_color' => '#D3C6F5','image' => 'uploads/24/04/1713261432-447.png','status' => '1','created_at' => '2024-04-16 15:57:12','updated_at' => '2024-04-16 15:57:12'),
            array('title' => 'Pos Sales','bg_color' => '#BCEBD7','image' => 'uploads/24/04/1713261480-659.png','status' => '1','created_at' => '2024-04-16 15:58:00','updated_at' => '2024-04-16 15:58:00'),
            array('title' => 'Dashboard','bg_color' => '#FEE8C2','image' => 'uploads/24/04/1713261520-929.png','status' => '1','created_at' => '2024-04-16 15:58:40','updated_at' => '2024-04-16 15:58:40'),
            array('title' => 'Subscription','bg_color' => '#BED8FF','image' => 'uploads/24/04/1713261611-324.png','status' => '1','created_at' => '2024-04-16 16:00:11','updated_at' => '2024-04-16 16:00:11'),
            array('title' => 'Multi Currency','bg_color' => '#FFDCF4','image' => 'uploads/24/04/1713261675-63.png','status' => '1','created_at' => '2024-04-16 16:01:15','updated_at' => '2024-04-16 16:01:15'),
            array('title' => '47+ Languages','bg_color' => '#C3CAFF','image' => 'uploads/24/04/1713261718-4.png','status' => '1','created_at' => '2024-04-16 16:01:58','updated_at' => '2024-04-16 16:01:58'),
            array('title' => 'Report','bg_color' => '#FFDDCC','image' => 'uploads/24/04/1713261757-428.png','status' => '1','created_at' => '2024-04-16 16:02:37','updated_at' => '2024-04-16 16:02:37'),
            array('title' => 'Loss/Profit','bg_color' => '#BCEBD7','image' => 'uploads/24/04/1713261799-681.png','status' => '1','created_at' => '2024-04-16 16:03:19','updated_at' => '2024-04-16 16:03:25'),
            array('title' => 'Stock','bg_color' => '#BCE9FF','image' => 'uploads/24/04/1713261842-604.png','status' => '1','created_at' => '2024-04-16 16:04:02','updated_at' => '2024-04-16 16:04:02'),
            array('title' => 'Expense','bg_color' => '#FBBDD3','image' => 'uploads/24/04/1713261880-146.png','status' => '1','created_at' => '2024-04-16 16:04:40','updated_at' => '2024-04-16 16:04:40'),
            array('title' => 'Income','bg_color' => '#F7C5FF','image' => 'uploads/24/04/1713261919-222.png','status' => '1','created_at' => '2024-04-16 16:05:19','updated_at' => '2024-04-16 16:05:19'),
            array('title' => 'Due List','bg_color' => '#FFD4D5','image' => 'uploads/24/04/1713261960-909.png','status' => '1','created_at' => '2024-04-16 16:06:00','updated_at' => '2024-04-16 16:06:00'),
            array('title' => 'Products','bg_color' => '#D3C6F5','image' => 'uploads/24/04/1713261996-808.png','status' => '1','created_at' => '2024-04-16 16:06:36','updated_at' => '2024-04-16 16:06:36'),
            array('title' => 'Purchase','bg_color' => '#BCEBD7','image' => 'uploads/24/04/1713262034-101.png','status' => '1','created_at' => '2024-04-16 16:07:14','updated_at' => '2024-04-16 16:07:14'),
            array('title' => 'Parties','bg_color' => '#FEE8C2','image' => 'uploads/24/04/1713262078-927.png','status' => '1','created_at' => '2024-04-16 16:07:58','updated_at' => '2024-04-16 16:07:58'),
            array('title' => 'Sales','bg_color' => '#BED8FF','image' => 'uploads/24/04/1713262168-328.png','status' => '1','created_at' => '2024-04-16 16:09:28','updated_at' => '2024-04-16 16:09:48')
          );

        Feature::insert($features);
    }
}
