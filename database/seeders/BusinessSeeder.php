<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $businesses = array(
            array('plan_subscribe_id' => '1','business_category_id' => '1','companyName' => 'Acnoo','will_expire' => now()->addYears(10),'address' => 'Dhaka','phoneNumber' => '1871165401','pictureUrl' => NULL,'subscriptionDate' => '2024-08-29 09:52:37','remainingShopBalance' => '0','shopOpeningBalance' => '100','created_at' => '2024-08-29 09:52:37','updated_at' => '2024-08-29 09:52:37')
        );

        Business::insert($businesses);
    }
}
