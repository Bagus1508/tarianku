<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dance;
use App\Models\QuizQuestion;

class QuizQuestionSeeder extends Seeder
{
    public function run(): void
    {
        // Definisikan pertanyaan per judul tarian
        $questions = [
            'Tari Gambyong'                 => ['Dari provinsi mana Tari Gambyong berasal?',     'Jawa Tengah',     10],
            'Tari Bedhaya'                  => ['Tari Bedhaya berasal dari keraton mana?',       'Yogyakarta',      12],
            'Tari Srimpi'                   => ['Srimpi adalah tari putri dari istana mana?',    'Surakarta',       12],
            // 'Tari Topeng Klana'             => ['Topeng Klana adalah tarian tradisional dari?',  'Cirebon',         8],
            // 'Tari Ronggeng'                 => ['Ronggeng biasa dipertunjukkan di daerah mana?',  'Jawa Barat',      8],
            // 'Tari Remo'                     => ['Remo adalah tari penyambutan khas provinsi?',   'Jawa Timur',      10],
            // 'Tari Tayub'                    => ['Tayub biasa dimainkan oleh?',                    'wanita',          6],
            // 'Tari Lengger'                  => ['Lengger berasal dari kabupaten mana?',          'Banyumas',        8],
            // 'Tari Jaran Kepang'             => ['Properti utama Tari Jaran Kepang adalah?',      'kuda anyaman',    5],
            // 'Tari Bambangan Cakil'          => ['Bambangan Cakil menceritakan pertarungan antara?', 'ksatria dan raksasa', 10],

            'Tari Piring'                   => ['Tari Piring berasal dari suku mana?',            'Minangkabau',     8],
            'Tari Tor-tor'                  => ['Tor-tor adalah tarian tradisional dari suku?',   'Batak',           8],
            'Tari Saman'                    => ['Saman berasal dari provinsi?',                   'Aceh',            10],
            // 'Tari Tanggai'                  => ['Tanggai biasa dipentaskan untuk acara apa?',     'penyambutan',     7],
            // 'Tari Zapin Melayu'             => ['Zapin Melayu dipengaruhi oleh budaya?',          'Arab',            9],
            // 'Tari Randai'                   => ['Randai menggabungkan tari dan apa?',             'teater',          10],
            // 'Tari Malulo'                   => ['Malulo adalah tarian asal provinsi?',            'Sulawesi Tenggara',  9],
            // 'Tari Payung'                   => ['Properti utama Tari Payung adalah?',             'payung',          5],
            // 'Tari Gelombang'                => ['Gelombang sering dipentaskan di daerah?',        'Sumatera Barat',  8],
            // 'Tari Andun'                    => ['Andun berasal dari provinsi mana?',              'Bengkulu',        8],

            'Tari Kancet Ledo'              => ['Kancet Ledo adalah tari tradisional dari suku?', 'Dayak Kenyah',    9],
            'Tari Hudoq'                    => ['Hudoq biasa ditampilkan saat upacara apa?',     'panen padi',      10],
            'Tari Giring-Giring'            => ['Giring-Giring menggunakan alat apa?',            'bambu',           5],
            // 'Tari Enggang'                  => ['Enggang meniru gerakan burung apa?',             'enggang',         7],
            // 'Tari Mandau'                   => ['Mandau melambangkan senjata tradisional suku?',  'Dayak',           8],
            // 'Tari Ajat Temuai Datai'        => ['Ajat Temuai Datai artinya?',                    'sambutan tamu',   6],
            // 'Tari Ngerangkau'               => ['Ngerangkau berkaitan dengan upacara?',           'pemakaman',       10],
            // 'Tari Baksa Kembang'            => ['Baksa Kembang berasal dari suku?',               'Banjar',          8],
            // 'Tari Japin'                    => ['Japin diiringi musik tradisional apa?',          'gambus',          7],
            // 'Tari Balian'                   => ['Balian adalah tari untuk tujuan apa?',           'penyembuhan',     10],
        ];

        // Pastikan data dance sudah ada
        foreach (Dance::all() as $dance) {
            $key = $dance->title;

            if (isset($questions[$key])) {
                [$text, $answer, $points] = $questions[$key];

                QuizQuestion::create([
                    'dance_id'      => $dance->id,
                    'question_text' => $text,
                    'correct_answer'=> $answer,
                    'points'        => $points,
                    'difficulty'    => rand(1,3),
                    'type'          => rand(1,2),
                ]);
            }
        }
    }
}