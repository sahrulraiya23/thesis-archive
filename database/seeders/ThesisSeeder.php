<?php

namespace Database\Seeders;

use App\Models\Thesis;
use Illuminate\Database\Seeder;

class ThesisSeeder extends Seeder
{
    public function run(): void
    {
        $theses = [
            [
                'title' => 'Implementasi Machine Learning untuk Prediksi Cuaca',
                'abstract' => 'Penelitian ini membahas penggunaan algoritma machine learning untuk memprediksi kondisi cuaca dengan tingkat akurasi yang tinggi...',
                'type' => 'skripsi',
                'author' => 'John Doe',
                'program_study' => 'Teknik Informatika',
                'year' => 2023,
            ],
            [
                'title' => 'Analisis Sistem Informasi Manajemen Rumah Sakit',
                'abstract' => 'Sistem informasi manajemen rumah sakit merupakan bagian penting dalam meningkatkan efisiensi pelayanan kesehatan...',
                'type' => 'skripsi',
                'author' => 'Jane Smith',
                'program_study' => 'Sistem Informasi',
                'year' => 2023,
            ],
            [
                'title' => 'Optimasi Algoritma Genetika untuk Traveling Salesman Problem',
                'abstract' => 'Traveling Salesman Problem adalah salah satu masalah optimasi kombinatorial yang kompleks...',
                'type' => 'tesis',
                'author' => 'Bob Johnson',
                'program_study' => 'Magister Teknik Informatika',
                'year' => 2022,
            ],
        ];

        foreach ($theses as $thesis) {
            Thesis::create($thesis);
        }
    }
}
