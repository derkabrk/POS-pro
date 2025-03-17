<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = array(
            array('business_id' => '1','brandName' => 'Tesla','icon' => NULL,'description' => 'Amet nobis laudanti','status' => '1','created_at' => '2024-11-05 09:38:10','updated_at' => '2024-11-05 09:38:10'),
            array('business_id' => '1','brandName' => 'Bugatti','icon' => NULL,'description' => 'Tesy','status' => '1','created_at' => '2024-11-05 12:58:00','updated_at' => '2024-11-05 12:58:00'),
            array('business_id' => '1','brandName' => 'Addidas','icon' => 'uploads/24/11/1732786045-554.png','description' => NULL,'status' => '1','created_at' => '2024-11-28 15:27:25','updated_at' => '2024-11-28 15:27:25'),
            array('business_id' => '1','brandName' => 'Puma','icon' => 'uploads/24/11/1732786079-799.png','description' => 'dssd','status' => '1','created_at' => '2024-11-28 15:27:59','updated_at' => '2024-11-28 15:27:59'),
            array('business_id' => '1','brandName' => 'Levi\'s','icon' => 'uploads/24/11/1732786106-281.png','description' => 'sasad','status' => '1','created_at' => '2024-11-28 15:28:26','updated_at' => '2024-11-28 15:28:26'),
            array('business_id' => '1','brandName' => 'H&M','icon' => 'uploads/24/11/1732786127-117.png','description' => 'sdcsds','status' => '1','created_at' => '2024-11-28 15:28:47','updated_at' => '2024-11-28 15:28:47'),
            array('business_id' => '1','brandName' => 'Rolex','icon' => 'uploads/24/11/1732786146-95.png','description' => 'dfszrfs','status' => '1','created_at' => '2024-11-28 15:29:06','updated_at' => '2024-11-28 15:29:06'),
            array('business_id' => '1','brandName' => 'Apple','icon' => 'uploads/24/11/1732786166-518.png','description' => 'sdfsed','status' => '1','created_at' => '2024-11-28 15:29:26','updated_at' => '2024-11-28 15:29:26'),
            array('business_id' => '1','brandName' => 'Schnell','icon' => 'uploads/24/11/1732786190-544.png','description' => 'dfsds','status' => '1','created_at' => '2024-11-28 15:29:50','updated_at' => '2024-11-28 15:29:50'),
            array('business_id' => '1','brandName' => 'Gucci','icon' => 'uploads/24/11/1732786229-315.png','description' => 'sdsd','status' => '1','created_at' => '2024-11-28 15:30:05','updated_at' => '2024-11-28 15:30:29'),
            array('business_id' => '1','brandName' => 'Zara','icon' => 'uploads/24/11/1732786248-250.png','description' => 'sdsd','status' => '1','created_at' => '2024-11-28 15:30:48','updated_at' => '2024-11-28 15:30:48'),
            array('business_id' => '1','brandName' => 'Nike','icon' => 'uploads/24/11/1732786269-552.png','description' => 'sdsd','status' => '1','created_at' => '2024-11-28 15:31:10','updated_at' => '2024-11-28 15:31:10'),
            array('business_id' => '1','brandName' => 'Gillette','icon' => 'uploads/24/11/1732786288-65.png','description' => 'dsds','status' => '1','created_at' => '2024-11-28 15:31:28','updated_at' => '2024-11-28 15:31:28'),
            array('business_id' => '1','brandName' => 'Accenture','icon' => 'uploads/24/11/1732786307-528.png','description' => 'sds','status' => '1','created_at' => '2024-11-28 15:31:47','updated_at' => '2024-11-28 15:31:47'),
            array('business_id' => '1','brandName' => 'Nescafe','icon' => 'uploads/24/11/1732786332-860.png','description' => 'sdsds','status' => '1','created_at' => '2024-11-28 15:32:12','updated_at' => '2024-11-28 15:32:12'),
            array('business_id' => '1','brandName' => 'Loreal','icon' => 'uploads/24/11/1732786349-739.png','description' => 'sdsd','status' => '1','created_at' => '2024-11-28 15:32:29','updated_at' => '2024-11-28 15:32:29')
        );


        Brand::insert($brands);
    }
}
