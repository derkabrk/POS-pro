<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = array(
            array('categoryName' => 'Fashion','business_id' => '1','icon' => NULL,'variationCapacity' => '1','variationColor' => '1','variationSize' => '1','variationType' => '1','variationWeight' => '1','status' => '1','created_at' => '2024-11-28 12:03:34','updated_at' => '2024-11-28 12:03:34'),
            array('categoryName' => 'Woman Dress','business_id' => '1','icon' => 'uploads/24/11/1732785432-929.png','variationCapacity' => '0','variationColor' => '1','variationSize' => '1','variationType' => '0','variationWeight' => '0','status' => '1','created_at' => '2024-11-28 15:17:13','updated_at' => '2024-11-28 15:17:13'),
            array('categoryName' => 'Fruits','business_id' => '1','icon' => 'uploads/24/11/1732785466-928.png','variationCapacity' => '0','variationColor' => '1','variationSize' => '1','variationType' => '1','variationWeight' => '0','status' => '1','created_at' => '2024-11-28 15:17:46','updated_at' => '2024-11-28 15:17:46'),
            array('categoryName' => 'T-Shirts','business_id' => '1','icon' => 'uploads/24/11/1732785505-514.png','variationCapacity' => '0','variationColor' => '1','variationSize' => '1','variationType' => '1','variationWeight' => '0','status' => '1','created_at' => '2024-11-28 15:18:25','updated_at' => '2024-11-28 15:18:25'),
            array('categoryName' => 'Shoes','business_id' => '1','icon' => 'uploads/24/11/1732785670-352.png','variationCapacity' => '0','variationColor' => '1','variationSize' => '1','variationType' => '0','variationWeight' => '0','status' => '1','created_at' => '2024-11-28 15:21:10','updated_at' => '2024-11-28 15:21:10'),
            array('categoryName' => 'Sunglass','business_id' => '1','icon' => 'uploads/24/11/1732785700-802.png','variationCapacity' => '0','variationColor' => '1','variationSize' => '1','variationType' => '1','variationWeight' => '0','status' => '1','created_at' => '2024-11-28 15:21:40','updated_at' => '2024-11-28 15:21:40'),
            array('categoryName' => 'Woman Bag','business_id' => '1','icon' => 'uploads/24/11/1732785720-233.png','variationCapacity' => '0','variationColor' => '0','variationSize' => '1','variationType' => '1','variationWeight' => '1','status' => '1','created_at' => '2024-11-28 15:22:00','updated_at' => '2024-11-28 15:22:00'),
            array('categoryName' => 'Smart Watch','business_id' => '1','icon' => 'uploads/24/11/1732785742-51.png','variationCapacity' => '1','variationColor' => '0','variationSize' => '1','variationType' => '0','variationWeight' => '0','status' => '1','created_at' => '2024-11-28 15:22:22','updated_at' => '2024-11-28 15:22:22'),
            array('categoryName' => 'Short Dress','business_id' => '1','icon' => 'uploads/24/11/1732785766-251.png','variationCapacity' => '0','variationColor' => '1','variationSize' => '0','variationType' => '1','variationWeight' => '0','status' => '1','created_at' => '2024-11-28 15:22:46','updated_at' => '2024-11-28 15:22:46'),
            array('categoryName' => 'Shorts Pants','business_id' => '1','icon' => 'uploads/24/11/1732785791-229.png','variationCapacity' => '0','variationColor' => '1','variationSize' => '1','variationType' => '1','variationWeight' => '0','status' => '1','created_at' => '2024-11-28 15:23:11','updated_at' => '2024-11-28 15:23:11'),
            array('categoryName' => 'Long sleeve shirt','business_id' => '1','icon' => 'uploads/24/11/1732785840-919.png','variationCapacity' => '0','variationColor' => '1','variationSize' => '1','variationType' => '1','variationWeight' => '0','status' => '1','created_at' => '2024-11-28 15:24:00','updated_at' => '2024-11-28 15:24:00'),
            array('categoryName' => 'Smart Phone','business_id' => '1','icon' => 'uploads/24/11/1732785866-840.png','variationCapacity' => '0','variationColor' => '1','variationSize' => '1','variationType' => '1','variationWeight' => '0','status' => '1','created_at' => '2024-11-28 15:24:26','updated_at' => '2024-11-28 15:24:26'),
            array('categoryName' => 'Computer','business_id' => '1','icon' => 'uploads/24/11/1732785888-33.png','variationCapacity' => '0','variationColor' => '1','variationSize' => '1','variationType' => '1','variationWeight' => '0','status' => '1','created_at' => '2024-11-28 15:24:48','updated_at' => '2024-11-28 15:24:48'),
            array('categoryName' => 'Electronic','business_id' => '1','icon' => 'uploads/24/11/1732785909-396.png','variationCapacity' => '0','variationColor' => '1','variationSize' => '1','variationType' => '1','variationWeight' => '1','status' => '1','created_at' => '2024-11-28 15:25:09','updated_at' => '2024-11-28 15:25:09')
          );

        Category::insert($categories);
    }
}
