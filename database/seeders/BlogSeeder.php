<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = array(
            array('user_id' => '1','title' => 'What is a Custom Point of Sale System? Pros & Cons','slug' => 'what-is-a-custom-point-of-sale-system-pros-cons','image' => 'uploads/24/06/1717396156-451.png','status' => '1','descriptions' => 'Blessing welcomed ladyship she met humo ured sir breeding her. Six curiosity day assurance bed necessary','tags' => '["Point of Sale","assurance bed necessary"]','meta' => '{"title":"What is a Custom Point of Sale System? Pros & Cons","description":"Blessing welcomed ladyship she met humo ured sir breeding her. Six curiosity day assurance bed necessary"}','created_at' => '2024-04-16 17:06:02','updated_at' => '2024-06-03 12:29:16'),
            array('user_id' => '1','title' => 'What is the Store of the Future? 8 Trends to Watch Out For','slug' => 'what-is-the-store-of-the-future-8-trends-to-watch-out-for','image' => 'uploads/24/06/1717396180-13.png','status' => '1','descriptions' => 'Blessing welcomed ladyship she met humo ured sir breeding her. Six curiosity day assurance bed necessary','tags' => '["Trends to Watch",null]','meta' => '{"title":"What is the Store of the Future? 8 Trends to Watch Out For","description":"Blessing welcomed ladyship she met humo ured sir breeding her. Six curiosity day assurance bed necessary"}','created_at' => '2024-04-16 17:07:13','updated_at' => '2024-06-03 12:29:40'),
            array('user_id' => '1','title' => 'How Much Are Point of Sale Transaction Fees?','slug' => 'how-much-are-point-of-sale-transaction-fees','image' => 'uploads/24/06/1717396207-62.png','status' => '1','descriptions' => 'Blessing welcomed ladyship she met humo ured sir breeding her. Six curiosity day assurance bed necessary','tags' => '["breeding","Point of Sale","Transaction"]','meta' => '{"title":"How Much Are Point of Sale Transaction Fees?","description":"Blessing welcomed ladyship she met humo ured sir breeding her. Six curiosity day assurance bed necessary"}','created_at' => '2024-04-16 17:08:34','updated_at' => '2024-06-03 12:30:07'),
            array('user_id' => '1','title' => 'Good Customer Service in Retail: 9 Characteristics','slug' => 'good-customer-service-in-retail-9-characteristics','image' => 'uploads/24/06/1717396233-816.png','status' => '1','descriptions' => 'Blessing welcomed ladyship she met humo ured sir breeding her. Six curiosity day assurance bed necessary','tags' => '["Six curiosity","Customer Service in Retail"]','meta' => '{"title":"Good Customer Service in Retail: 9 Characteristics","description":"Blessing welcomed ladyship she met humo ured sir breeding her. Six curiosity day assurance bed necessary"}','created_at' => '2024-04-16 17:11:24','updated_at' => '2024-06-03 12:30:33'),
            array('user_id' => '1','title' => 'What Are the 10 Risks of Inventory Transfer?','slug' => 'what-are-the-10-risks-of-inventory-transfer','image' => 'uploads/24/06/1717396254-420.png','status' => '1','descriptions' => 'Blessing welcomed ladyship she met humo ured sir breeding her. Six curiosity day assurance bed necessary','tags' => '["Risks of Inventory","assurance bed necessary"]','meta' => '{"title":"What Are the 10 Risks of Inventory Transfer?","description":"Blessing welcomed ladyship she met humo ured sir breeding her. Six curiosity day assurance bed necessary"}','created_at' => '2024-04-16 17:12:53','updated_at' => '2024-06-03 12:30:54'),
            array('user_id' => '1','title' => 'What is the Store of the Future? 12 Trends to Watch Out For','slug' => 'what-is-the-store-of-the-future-12-trends-to-watch-out-for','image' => 'uploads/24/06/1717396274-353.png','status' => '1','descriptions' => 'Blessing welcomed ladyship she met humo ured sir breeding her. Six curiosity day assurance bed necessary','tags' => '["Trends to Watch","ladyship she met"]','meta' => '{"title":"What is the Store of the Future? 8 Trends to Watch Out For","description":"Blessing welcomed ladyship she met humo ured sir breeding her. Six curiosity day assurance bed necessary"}','created_at' => '2024-04-16 17:15:42','updated_at' => '2024-06-03 12:31:15')
          );

        Blog::insert($blogs);

    }
}
