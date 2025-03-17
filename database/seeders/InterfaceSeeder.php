<?php

namespace Database\Seeders;

use App\Models\PosAppInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InterfaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pos_app_interfaces = array(
            array('image' => 'uploads/24/06/1717395096-735.png','status' => '1','created_at' => '2024-04-16 16:18:51','updated_at' => '2024-06-03 12:11:36'),
            array('image' => 'uploads/24/06/1717395110-964.png','status' => '1','created_at' => '2024-04-16 16:19:43','updated_at' => '2024-06-03 12:11:50'),
            array('image' => 'uploads/24/06/1717395121-241.png','status' => '1','created_at' => '2024-04-18 14:56:07','updated_at' => '2024-06-03 12:12:01'),
            array('image' => 'uploads/24/06/1717395131-322.png','status' => '1','created_at' => '2024-04-18 14:56:17','updated_at' => '2024-06-03 12:12:11'),
            array('image' => 'uploads/24/06/1717396714-782.png','status' => '1','created_at' => '2024-06-03 12:38:34','updated_at' => '2024-06-03 12:38:34'),
            array('image' => 'uploads/24/06/1717396725-163.png','status' => '1','created_at' => '2024-06-03 12:38:45','updated_at' => '2024-06-03 12:38:45'),
            array('image' => 'uploads/24/06/1717396734-535.png','status' => '1','created_at' => '2024-06-03 12:38:54','updated_at' => '2024-06-03 12:38:54'),
            array('image' => 'uploads/24/06/1717396745-346.png','status' => '1','created_at' => '2024-06-03 12:39:05','updated_at' => '2024-06-03 12:39:05')
          );
        PosAppInterface::insert($pos_app_interfaces);
    }
}
