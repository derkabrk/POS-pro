<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = array(
            array('id' => '1','text' => 'Although this is well intentioned and the goal certainly is to reduce the quantity of these bothersome thoughts, the technique is','star' => '5','client_name' => 'Leslie Alexander','client_image' => 'uploads/24/04/1713260567-541.png','work_at' => 'Ceo Google.inc','created_at' => '2024-04-16 15:42:47','updated_at' => '2024-04-16 15:42:47'),
            array('id' => '2','text' => 'Although this is well intentioned and the goal certainly is to reduce the quantity of these bothersome thoughts, the technique is','star' => '5','client_name' => 'Eleanor Pena','client_image' => 'uploads/24/04/1713260604-397.png','work_at' => 'Ceo Google.inc','created_at' => '2024-04-16 15:43:24','updated_at' => '2024-04-16 15:43:24'),
            array('id' => '3','text' => 'Although this is well intentioned and the goal certainly is to reduce the quantity of these bothersome thoughts, the technique is','star' => '5','client_name' => 'Cody Fisher','client_image' => 'uploads/24/04/1713260669-111.png','work_at' => 'Ceo Google.inc','created_at' => '2024-04-16 15:44:29','updated_at' => '2024-04-16 15:44:29')
          );

        Testimonial::insert($testimonials);
    }
}
