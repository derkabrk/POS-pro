<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = array(
            array('productName' => 'Tesla Cyber Tank','business_id' => '1','unit_id' => '1','brand_id' => '1','category_id' => '1','productCode' => '0001','productPicture' => 'uploads/24/11/1731320844-991.jpg','productDealerPrice' => '150','productPurchasePrice' => '100','productSalePrice' => '200','productWholeSalePrice' => '180','productStock' => '10','size' => '48 m','type' => 'car','color' => 'blue','weight' => '1000 kg','capacity' => '2','productManufacturer' => 'Tesla','meta' => NULL,'created_at' => '2024-11-05 10:47:06','updated_at' => '2024-11-11 16:27:24'),
            array('productName' => 'Bugatti','business_id' => '1','unit_id' => '1','brand_id' => '2','category_id' => '1','productCode' => '8941161113050','productPicture' => 'uploads/24/11/1731320820-191.jpg','productDealerPrice' => '220','productPurchasePrice' => '200','productSalePrice' => '300','productWholeSalePrice' => '250','productStock' => '10','size' => '50 m','type' => 'Car','color' => 'Black','weight' => '1000','capacity' => '2','productManufacturer' => 'Bugatti','meta' => NULL,'created_at' => '2024-11-05 12:50:23','updated_at' => '2024-11-11 16:27:00'),
            array('productName' => 'Tesla Electric','business_id' => '1','unit_id' => '1','brand_id' => '1','category_id' => '1','productCode' => '8941153501582','productPicture' => 'uploads/24/11/1731320804-960.jpg','productDealerPrice' => '70','productPurchasePrice' => '50','productSalePrice' => '100','productWholeSalePrice' => '90','productStock' => '10','size' => '66','type' => 'Car','color' => 'Red','weight' => '1000','capacity' => '2','productManufacturer' => 'Tesla','meta' => NULL,'created_at' => '2024-11-05 12:53:41','updated_at' => '2024-11-11 16:26:44'),
            array('productName' => 'Bugatti Chiron','business_id' => '1','unit_id' => '1','brand_id' => '2','category_id' => '1','productCode' => 'L-00001074','productPicture' => 'uploads/24/11/1731320789-386.jpg','productDealerPrice' => '230','productPurchasePrice' => '220','productSalePrice' => '270','productWholeSalePrice' => '250','productStock' => '9','size' => '57','type' => 'Car','color' => 'Black','weight' => '1000','capacity' => '2','productManufacturer' => 'Bugatti','meta' => NULL,'created_at' => '2024-11-05 13:00:52','updated_at' => '2024-11-11 16:26:30')
          );

        Product::insert($products);
    }
}
