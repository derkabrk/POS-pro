<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = array(
            array('name' => 'Comming Soon','icon' => 'uploads/24/04/1713263132-74.png','status' => '1','created_at' => '2024-04-16 16:25:32','updated_at' => '2024-04-16 16:25:32'),
            array('name' => 'Portuguese (BR)','icon' => 'uploads/24/04/1713263352-609.png','status' => '1','created_at' => '2024-04-16 16:29:12','updated_at' => '2024-04-16 16:29:12'),
            array('name' => 'Chinese (TW)','icon' => 'uploads/24/04/1713263390-316.png','status' => '1','created_at' => '2024-04-16 16:29:50','updated_at' => '2024-04-16 16:29:50'),
            array('name' => 'Chinese (CN)','icon' => 'uploads/24/04/1713263431-511.png','status' => '1','created_at' => '2024-04-16 16:30:31','updated_at' => '2024-04-16 16:30:31'),
            array('name' => 'Azerbaijani','icon' => 'uploads/24/04/1713263469-306.png','status' => '1','created_at' => '2024-04-16 16:31:09','updated_at' => '2024-04-16 16:31:09'),
            array('name' => 'Kazakhastan','icon' => 'uploads/24/04/1713263502-600.png','status' => '1','created_at' => '2024-04-16 16:31:42','updated_at' => '2024-04-16 16:31:42'),
            array('name' => 'Tigrinya','icon' => 'uploads/24/04/1713263543-203.png','status' => '1','created_at' => '2024-04-16 16:32:23','updated_at' => '2024-04-16 16:32:23'),
            array('name' => 'Burmuse','icon' => 'uploads/24/04/1713263573-197.png','status' => '1','created_at' => '2024-04-16 16:32:53','updated_at' => '2024-04-16 16:32:53'),
            array('name' => 'Swahili','icon' => 'uploads/24/04/1713263661-746.png','status' => '1','created_at' => '2024-04-16 16:33:31','updated_at' => '2024-04-16 16:34:21'),
            array('name' => 'Slovak','icon' => 'uploads/24/04/1713263705-676.png','status' => '1','created_at' => '2024-04-16 16:35:05','updated_at' => '2024-04-16 16:35:05'),
            array('name' => 'Albanian','icon' => 'uploads/24/04/1713263748-483.png','status' => '1','created_at' => '2024-04-16 16:35:48','updated_at' => '2024-04-16 16:35:48'),
            array('name' => 'Urdu','icon' => 'uploads/24/04/1713263785-829.png','status' => '1','created_at' => '2024-04-16 16:36:25','updated_at' => '2024-04-16 16:36:25'),
            array('name' => 'Danish','icon' => 'uploads/24/04/1713263817-546.png','status' => '1','created_at' => '2024-04-16 16:36:57','updated_at' => '2024-04-16 16:36:57'),
            array('name' => 'Swedish','icon' => 'uploads/24/04/1713263851-61.png','status' => '1','created_at' => '2024-04-16 16:37:31','updated_at' => '2024-04-16 16:37:31'),
            array('name' => 'Marathi','icon' => 'uploads/24/04/1713263883-87.png','status' => '1','created_at' => '2024-04-16 16:38:03','updated_at' => '2024-04-16 16:38:03'),
            array('name' => 'Kannada','icon' => 'uploads/24/04/1713263922-810.png','status' => '1','created_at' => '2024-04-16 16:38:42','updated_at' => '2024-04-16 16:38:42'),
            array('name' => 'Czech','icon' => 'uploads/24/04/1713263954-737.png','status' => '1','created_at' => '2024-04-16 16:39:14','updated_at' => '2024-04-16 16:39:14'),
            array('name' => 'Русский','icon' => 'uploads/24/04/1713263985-750.png','status' => '1','created_at' => '2024-04-16 16:39:45','updated_at' => '2024-04-16 16:39:45'),
            array('name' => 'Lao','icon' => 'uploads/24/04/1713264024-299.png','status' => '1','created_at' => '2024-04-16 16:40:24','updated_at' => '2024-04-16 16:40:24'),
            array('name' => 'Ukrainian','icon' => 'uploads/24/04/1713264051-664.png','status' => '1','created_at' => '2024-04-16 16:40:51','updated_at' => '2024-04-16 16:40:51'),
            array('name' => 'Khmer','icon' => 'uploads/24/04/1713264076-901.png','status' => '1','created_at' => '2024-04-16 16:41:16','updated_at' => '2024-04-16 16:41:16'),
            array('name' => 'Serbian','icon' => 'uploads/24/04/1713264104-342.png','status' => '1','created_at' => '2024-04-16 16:41:44','updated_at' => '2024-04-16 16:41:44'),
            array('name' => 'Turkish','icon' => 'uploads/24/04/1713264131-167.png','status' => '1','created_at' => '2024-04-16 16:42:11','updated_at' => '2024-04-16 16:42:11'),
            array('name' => 'Persian','icon' => 'uploads/24/04/1713264160-560.png','status' => '1','created_at' => '2024-04-16 16:42:40','updated_at' => '2024-04-16 16:42:40'),
            array('name' => 'Indonesian','icon' => 'uploads/24/04/1713264189-370.png','status' => '1','created_at' => '2024-04-16 16:43:09','updated_at' => '2024-04-16 16:43:09'),
            array('name' => 'Malay','icon' => 'uploads/24/04/1713264218-608.png','status' => '1','created_at' => '2024-04-16 16:43:38','updated_at' => '2024-04-16 16:43:38'),
            array('name' => 'Korean','icon' => 'uploads/24/04/1713264250-943.png','status' => '1','created_at' => '2024-04-16 16:44:10','updated_at' => '2024-04-16 16:44:10'),
            array('name' => 'Greek','icon' => 'uploads/24/04/1713264276-755.png','status' => '1','created_at' => '2024-04-16 16:44:37','updated_at' => '2024-04-16 16:44:37'),
            array('name' => 'Finland','icon' => 'uploads/24/04/1713264306-829.png','status' => '1','created_at' => '2024-04-16 16:45:06','updated_at' => '2024-04-16 16:45:06'),
            array('name' => 'Hungarian','icon' => 'uploads/24/04/1713264331-326.png','status' => '1','created_at' => '2024-04-16 16:45:31','updated_at' => '2024-04-16 16:45:31'),
            array('name' => 'Polish','icon' => 'uploads/24/04/1713264358-886.png','status' => '1','created_at' => '2024-04-16 16:45:58','updated_at' => '2024-04-16 16:45:58'),
            array('name' => 'Bengali','icon' => 'uploads/24/04/1713264388-157.png','status' => '1','created_at' => '2024-04-16 16:46:28','updated_at' => '2024-04-16 16:46:28'),
            array('name' => 'Portuguese','icon' => 'uploads/24/04/1713264423-206.png','status' => '1','created_at' => '2024-04-16 16:47:03','updated_at' => '2024-04-16 16:47:03'),
            array('name' => 'Hebrew','icon' => 'uploads/24/04/1713264450-677.png','status' => '1','created_at' => '2024-04-16 16:47:30','updated_at' => '2024-04-16 16:47:30'),
            array('name' => 'Dutch','icon' => 'uploads/24/04/1713264476-832.png','status' => '1','created_at' => '2024-04-16 16:47:56','updated_at' => '2024-04-16 16:47:56'),
            array('name' => 'Bosnian','icon' => 'uploads/24/04/1713264505-83.png','status' => '1','created_at' => '2024-04-16 16:48:25','updated_at' => '2024-04-16 16:48:25'),
            array('name' => 'Thai','icon' => 'uploads/24/04/1713264534-163.png','status' => '1','created_at' => '2024-04-16 16:48:54','updated_at' => '2024-04-16 16:48:54'),
            array('name' => 'Italian','icon' => 'uploads/24/04/1713264559-834.png','status' => '1','created_at' => '2024-04-16 16:49:19','updated_at' => '2024-04-16 16:49:19'),
            array('name' => 'Vietnamese','icon' => 'uploads/24/04/1713264586-161.png','status' => '1','created_at' => '2024-04-16 16:49:46','updated_at' => '2024-04-16 16:49:46'),
            array('name' => 'German','icon' => 'uploads/24/04/1713264610-223.png','status' => '1','created_at' => '2024-04-16 16:50:10','updated_at' => '2024-04-16 16:50:10'),
            array('name' => 'Romanian','icon' => 'uploads/24/04/1713264637-599.png','status' => '1','created_at' => '2024-04-16 16:50:37','updated_at' => '2024-04-16 16:50:37'),
            array('name' => 'Arabic','icon' => 'uploads/24/04/1713264667-831.png','status' => '1','created_at' => '2024-04-16 16:51:07','updated_at' => '2024-04-16 16:51:07'),
            array('name' => 'Japanese','icon' => 'uploads/24/04/1713264693-992.png','status' => '1','created_at' => '2024-04-16 16:51:33','updated_at' => '2024-04-16 16:51:33'),
            array('name' => 'Spanish','icon' => 'uploads/24/04/1713264720-829.png','status' => '1','created_at' => '2024-04-16 16:52:00','updated_at' => '2024-04-16 16:52:00'),
            array('name' => 'French','icon' => 'uploads/24/04/1713264745-349.png','status' => '1','created_at' => '2024-04-16 16:52:25','updated_at' => '2024-04-16 16:52:25'),
            array('name' => 'Hindi','icon' => 'uploads/24/04/1713264770-181.png','status' => '1','created_at' => '2024-04-16 16:52:50','updated_at' => '2024-04-16 16:52:50'),
            array('name' => 'Chinese','icon' => 'uploads/24/04/1713264810-300.png','status' => '1','created_at' => '2024-04-16 16:53:30','updated_at' => '2024-04-16 16:53:30'),
            array('name' => 'English','icon' => 'uploads/24/04/1713264836-549.png','status' => '1','created_at' => '2024-04-16 16:53:56','updated_at' => '2024-04-16 16:53:56')
          );

        Language::insert($languages);
    }
}
