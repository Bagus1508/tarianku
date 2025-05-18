<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Dance;
use Illuminate\Database\Seeder;

class DancesSeeder extends Seeder
{
    public function run(): void
    {
        $dances = [
            'Jawa' => [
                ['title' => 'Tari Gambyong', 'description' => 'Tari klasik Jawa Tengah yang anggun dan lemah gemulai.'],
                ['title' => 'Tari Bedhaya', 'description' => 'Tarian sakral keraton Yogyakarta yang penuh makna filosofi.'],
                ['title' => 'Tari Srimpi', 'description' => 'Tari putri halus yang menggambarkan kelembutan dan keanggunan.'],
                ['title' => 'Tari Topeng Klana', 'description' => 'Tarian maskulin dari Cirebon dengan karakter kuat.'],
                ['title' => 'Tari Ronggeng', 'description' => 'Tari rakyat Jawa Barat yang ceria dan interaktif.'],
                ['title' => 'Tari Remo', 'description' => 'Tari penyambutan khas Jawa Timur dengan gerak gagah.'],
                ['title' => 'Tari Tayub', 'description' => 'Tarian hiburan rakyat di Jawa Tengah dan Timur.'],
                ['title' => 'Tari Lengger', 'description' => 'Tarian perempuan Banyumas yang dinamis dan energik.'],
                ['title' => 'Tari Jaran Kepang', 'description' => 'Tari tradisional menggunakan kuda-kudaan dari anyaman.'],
                ['title' => 'Tari Bambangan Cakil', 'description' => 'Tari perkelahian antara ksatria dan raksasa.'],
            ],
            'Sumatera' => [
                ['title' => 'Tari Piring', 'description' => 'Tari Minangkabau menggunakan piring sebagai properti utama.'],
                ['title' => 'Tari Tor-tor', 'description' => 'Tarian khas Batak dengan gerak tangan ekspresif.'],
                ['title' => 'Tari Saman', 'description' => 'Tarian cepat dan kompak dari Gayo, Aceh.'],
                ['title' => 'Tari Tanggai', 'description' => 'Tarian penyambutan dari Palembang, Sumatera Selatan.'],
                ['title' => 'Tari Zapin Melayu', 'description' => 'Tarian bernuansa Islam dari Melayu Riau.'],
                ['title' => 'Tari Randai', 'description' => 'Tari teaterikal Minangkabau dengan unsur cerita.'],
                ['title' => 'Tari Malulo', 'description' => 'Tarian beramai-ramai dari masyarakat Tolaki di Sumatera.'],
                ['title' => 'Tari Payung', 'description' => 'Tari romantis dari Minangkabau yang menggunakan payung.'],
                ['title' => 'Tari Gelombang', 'description' => 'Tari penyambutan dari Minangkabau yang dinamis.'],
                ['title' => 'Tari Andun', 'description' => 'Tari pergaulan dari Bengkulu.'],
            ],
            'Kalimantan' => [
                ['title' => 'Tari Kancet Ledo', 'description' => 'Tari Dayak Kenyah yang menggambarkan kelembutan wanita.'],
                ['title' => 'Tari Hudoq', 'description' => 'Tari topeng tradisional Dayak untuk upacara panen.'],
                ['title' => 'Tari Giring-Giring', 'description' => 'Tarian menggunakan bambu sebagai alat bunyi.'],
                ['title' => 'Tari Enggang', 'description' => 'Tari yang meniru burung enggang, simbol suku Dayak.'],
                ['title' => 'Tari Mandau', 'description' => 'Tari peperangan Dayak dengan senjata tradisional.'],
                ['title' => 'Tari Ajat Temuai Datai', 'description' => 'Tarian sambutan suku Dayak Iban.'],
                ['title' => 'Tari Ngerangkau', 'description' => 'Tari pemakaman dari Dayak Tiwah.'],
                ['title' => 'Tari Baksa Kembang', 'description' => 'Tari penyambutan dari Banjar Kalimantan Selatan.'],
                ['title' => 'Tari Japin', 'description' => 'Tari hiburan Melayu Banjar dengan iringan gambus.'],
                ['title' => 'Tari Balian', 'description' => 'Tari penyembuhan tradisional dari suku Dayak.'],
            ],
        ];

        foreach ($dances as $categoryName => $danceList) {
            $category = Categories::where('name', $categoryName)->first();
            if (!$category) continue;

            foreach ($danceList as $dance) {
                Dance::create([
                    'categories_id'    => $category->id,
                    'title'            => $dance['title'],
                    'description'      => $dance['description'],
                    'origin_region'    => $categoryName,
                    'attachment1'      => 'dances/attachment1/sample1.png',
                    'attachment2'      => 'dances/attachment2/sample2.png',
                    'is_archived'      => false,
                    'difficulty_level' => rand(1, 3),
                ]);
            }
        }
    }
}