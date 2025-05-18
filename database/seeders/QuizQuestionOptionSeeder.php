<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionOption;

class QuizQuestionOptionSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar jawaban alternatif untuk beberapa correct_answer
        $alternativeOptions = [
            'Jawa Tengah' => ['Jawa Barat', 'Jawa Timur', 'Bali'],
            'Yogyakarta' => ['Surakarta', 'Bandung', 'Semarang'],
            'Surakarta' => ['Jakarta', 'Malang', 'Denpasar'],
            // 'Cirebon' => ['Bogor', 'Bekasi', 'Garut'],
            // 'Jawa Barat' => ['Jawa Tengah', 'Banten', 'Lampung'],
            // 'Jawa Timur' => ['Jawa Tengah', 'NTB', 'Sulawesi Selatan'],
            // 'wanita' => ['pria', 'anak-anak', 'penari asing'],
            // 'Banyumas' => ['Solo', 'Purwokerto', 'Kebumen'],
            // 'kuda anyaman' => ['tombak', 'payung', 'kendang'],
            // 'ksatria dan raksasa' => ['raja dan dayang', 'rakyat dan bangsawan', 'petani dan pedagang'],

            'Minangkabau' => ['Melayu', 'Bugis', 'Betawi'],
            'Batak' => ['Aceh', 'Rejang', 'Mandailing'],
            'Aceh' => ['Padang', 'Medan', 'Palembang'],
            // 'penyambutan' => ['pernikahan', 'kematian', 'panen'],
            // 'Arab' => ['India', 'China', 'Eropa'],
            // 'teater' => ['nyanyian', 'melukis', 'puisi'],
            // 'Sulawesi Tenggara' => ['Kalimantan Timur', 'Papua', 'Sumatera Selatan'],
            // 'payung' => ['kipas', 'selendang', 'tombak'],
            // 'Sumatera Barat' => ['Sumatera Utara', 'Aceh', 'Bengkulu'],
            // 'Bengkulu' => ['Jambi', 'Lampung', 'Sumsel'],

            'Dayak Kenyah' => ['Dayak Ngaju', 'Banjar', 'Bugis'],
            'panen padi' => ['pernikahan', 'melahirkan', 'kematian'],
            'bambu' => ['kendang', 'rebana', 'seruling'],
            // 'enggang' => ['elang', 'rajawali', 'cenderawasih'],
            // 'Dayak' => ['Bugis', 'Toraja', 'Melayu'],
            // 'sambutan tamu' => ['perang', 'pernikahan', 'kelahiran'],
            // 'pemakaman' => ['perkawinan', 'kelahiran', 'penyambutan'],
            // 'Banjar' => ['Madura', 'Bali', 'Ambon'],
            // 'gambus' => ['kendang', 'rebana', 'angklung'],
            // 'penyembuhan' => ['kesejahteraan', 'kemenangan', 'perayaan'],
        ];

        $questions = QuizQuestion::all();

        foreach ($questions as $question) {
            $correct = $question->correct_answer;
            $alternatives = $alternativeOptions[$correct] ?? ['Pilihan A', 'Pilihan B', 'Pilihan C'];

            // Insert correct answer
            QuizQuestionOption::create([
                'quiz_question_id' => $question->id,
                'option_text' => $correct,
                'is_correct' => true,
            ]);

            // Insert incorrect answers
            foreach ($alternatives as $alt) {
                QuizQuestionOption::create([
                    'quiz_question_id' => $question->id,
                    'option_text' => $alt,
                    'is_correct' => false,
                ]);
            }
        }
    }
}