<?php

namespace Database\Seeders;

use App\Models\PlanSubscribe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSubscribeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plan_subscribes = array(
            array('plan_id' => '1','business_id' => '1','gateway_id' => NULL,'price' => '0.00','payment_status' => 'unpaid','duration' => '7','notes' => NULL,'created_at' => now(),'updated_at' => now()),
        );

        PlanSubscribe::insert($plan_subscribes);
    }
}
