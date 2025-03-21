<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PlanSeeder::class,
            BusinessCategorySeeder::class,
            BusinessSeeder::class,
            PermissionSeeder::class,
            OptionTableSeeder::class,
            BlogSeeder::class,
            UserSeeder::class,
            FeatureSeeder::class,
            InterfaceSeeder::class,
            LanguageSeeder::class,
            TestimonialSeeder::class,
            CurrencySeeder::class,
            GatewaySeeder::class,
            PlanSubscribeSeeder::class,
            AdvertiseSeeder::class,
            BrandSeeder::class,
            UnitSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            PartySeeder::class,
            PaymentTypeSeeder::class,
        ]);
    }
}
