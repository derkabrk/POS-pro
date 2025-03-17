<?php

namespace Database\Seeders;

use App\Models\Party;
use Illuminate\Database\Seeder;

class PartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parties = array(
            array('name' => 'Amber Bush','business_id' => '1','email' => 'vujamec@mailinator.com','type' => 'Retailer','phone' => '21','due' => '0','address' => 'Mollit ut duis esse','image' => 'uploads/24/11/1730782329-403.jpg','status' => '1','created_at' => '2024-11-05 10:52:09','updated_at' => '2024-11-05 10:52:09'),
            array('name' => 'Zoe Kidd','business_id' => '1','email' => 'seroqoveby@mailinator.com','type' => 'Dealer','phone' => '98','due' => '0','address' => 'Voluptas saepe animi','image' => 'uploads/24/11/1730782357-657.jpg','status' => '1','created_at' => '2024-11-05 10:52:37','updated_at' => '2024-11-05 10:52:37'),
            array('name' => 'Porter Flynn','business_id' => '1','email' => 'jeronog@mailinator.com','type' => 'Wholesaler','phone' => '46','due' => '0','address' => 'Itaque Nam aliquip s','image' => 'uploads/24/11/1730782371-147.jpg','status' => '1','created_at' => '2024-11-05 10:52:51','updated_at' => '2024-11-05 10:52:51'),
            array('name' => 'Chase Farmer','business_id' => '1','email' => 'romukuvima@mailinator.com','type' => 'Supplier','phone' => '82','due' => '0','address' => 'Quaerat impedit mag','image' => 'uploads/24/11/1730782393-244.jpg','status' => '1','created_at' => '2024-11-05 10:53:13','updated_at' => '2024-11-05 10:53:13')
          );

        Party::insert($parties);
    }
}
