@extends('layouts.admin')

@section('title', 'Cek Plagiarisme Judul')

@section('header')
    <h1 class="text-4xl font-bold mb-2">Cek Plagiarisme Judul</h1>
    <p class="text-xl text-white/80">Periksa kemiripan judul dengan database tugas akhir</p>
@endsection

@section('content')
    <!-- Form Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i data-feather="shield" class="w-5 h-5 mr-2"></i>
                Form Pengecekan
            </h3>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('plagiarism.submit') }}">
                @csrf
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Masukkan Judul Tugas Akhir
                    </label>
                    <div class="relative">
                        <textarea name="title" id="title" rows="4"
                            class="block w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-300 @enderror"
                            placeholder="Contoh: Implementasi Machine Learning untuk Prediksi Cuaca Menggunakan Algoritma Neural Network"
                            required>{{ old('title', $inputTitle ?? '') }}</textarea>
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i data-feather="alert-circle" class="w-4 h-4 mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                <button type="submit"
                    class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-lg transition-all duration-200 flex items-center justify-center">
                    <i data-feather="search" class="w-5 h-5 mr-2"></i>
                    Cek Plagiarisme
                </button>
            </form>
        </div>
    </div>

    @if (isset($inputTitle))
        <!-- Results Section -->
        <div class="space-y-6">
            <!-- Overall Result -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i data-feather="bar-chart-2" class="w-5 h-5 mr-2"></i>
                        Hasil Analisis
                    </h3>
                </div>
                <div class="p-6">
                    <div
                        class="border rounded-lg p-6 {{ $maxSimilarity > 70 ? 'bg-red-50 border-red-200' : ($maxSimilarity > 30 ? 'bg-yellow-50 border-yellow-200' : 'bg-green-50 border-green-200') }}">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4
                                    class="text-2xl font-bold {{ $maxSimilarity > 70 ? 'text-red-800' : ($maxSimilarity > 30 ? 'text-yellow-800' : 'text-green-800') }}">
                                    {{ number_format($maxSimilarity, 1) }}% Kemiripan Tertinggi
                                </h4>
                                <p
                                    class="text-sm {{ $maxSimilarity > 70 ? 'text-red-600' : ($maxSimilarity > 30 ? 'text-yellow-600' : 'text-green-600') }} mt-1">
                                    @if ($maxSimilarity > 70)
                                        <i data-feather="alert-triangle" class="w-4 h-4 mr-1 inline"></i>
                                        Tingkat kemiripan tinggi - perlu revisi signifikan
                                    @elseif($maxSimilarity > 30)
                                        <i data-feather="alert-circle" class="w-4 h-4 mr-1 inline"></i>
                                        Tingkat kemiripan sedang - perlu perhatian
                                    @else
                                        <i data-feather="check-circle" class="w-4 h-4 mr-1 inline"></i>
                                        Tingkat kemiripan rendah - relatif aman
                                    @endif
                                </p>
                            </div>
                            <div class="text-right">
                                <div
                                    class="w-20 h-20 rounded-full border-8 flex items-center justify-center {{ $maxSimilarity > 70 ? 'border-red-200 bg-red-100' : ($maxSimilarity > 30 ? 'border-yellow-200 bg-yellow-100' : 'border-green-200 bg-green-100') }}">
                                    <span
                                        class="text-lg font-bold {{ $maxSimilarity > 70 ? 'text-red-600' : ($maxSimilarity > 30 ? 'text-yellow-600' : 'text-green-600') }}">
                                        {{ number_format($maxSimilarity, 0) }}%
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-4">
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="h-3 rounded-full transition-all duration-1000 {{ $maxSimilarity > 70 ? 'bg-gradient-to-r from-red-400 to-red-600' : ($maxSimilarity > 30 ? 'bg-gradient-to-r from-yellow-400 to-yellow-600' : 'bg-gradient-to-r from-green-400 to-green-600') }}"
                                    style="width: {{ $maxSimilarity }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Results -->
            @if (!empty($similarities))
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i data-feather="list" class="w-5 h-5 mr-2"></i>
                            Daftar Kemiripan Detail
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Menampilkan judul dengan kemiripan > 10%
                        </p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach ($similarities as $similarity)
                                @if ($similarity['percentage'] > 10)
                                    <div
                                        class="border rounded-lg p-4 hover:shadow-md transition-shadow {{ $similarity['percentage'] > 70 ? 'bg-red-50 border-red-200' : ($similarity['percentage'] > 30 ? 'bg-yellow-50 border-yellow-200' : 'bg-gray-50 border-gray-200') }}">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1 pr-4">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h4 class="font-semibold text-gray-900">
                                                        {{ $similarity['thesis']->title }}
                                                    </h4>
                                                    <div class="flex items-center">
                                                        <span
                                                            class="text-lg font-bold {{ $similarity['percentage'] > 70 ? 'text-red-600' : ($similarity['percentage'] > 30 ? 'text-yellow-600' : 'text-gray-600') }}">
                                                            {{ number_format($similarity['percentage'], 1) }}%
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                                                    <div class="flex items-center">
                                                        <i data-feather="user" class="w-4 h-4 mr-1"></i>
                                                        {{ $similarity['thesis']->author }}
                                                    </div>
                                                    <div class="flex items-center">
                                                        <i data-feather="book" class="w-4 h-4 mr-1"></i>
                                                        {{ ucfirst($similarity['thesis']->type) }}
                                                    </div>
                                                    <div class="flex items-center">
                                                        <i data-feather="calendar" class="w-4 h-4 mr-1"></i>
                                                        {{ $similarity['thesis']->year }}
                                                    </div>
                                                </div>

                                                <p class="text-sm text-gray-600 mt-2">
                                                    <strong>Program Studi:</strong>
                                                    {{ $similarity['thesis']->program_study }}
                                                </p>

                                                <div class="mt-3">
                                                    <a href="{{ route('public.thesis.show', $similarity['thesis']) }}"
                                                        class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 transition-colors">
                                                        <i data-feather="external-link" class="w-4 h-4 mr-1"></i>
                                                        Lihat Detail
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-12 text-center">
                        <i data-feather="check-circle" class="w-16 h-16 text-green-500 mx-auto mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Kemiripan Signifikan</h3>
                        <p class="text-gray-600">Judul yang Anda masukkan tidak memiliki kemiripan yang signifikan dengan
                            data yang ada dalam sistem.</p>
                    </div>
                </div>
            @endif

            <!-- Disclaimer -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex items-start">
                    <i data-feather="info" class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900 mb-1">Penting untuk Diketahui</h4>
                        <p class="text-sm text-blue-800">
                            Hasil pengecekan ini hanya berdasarkan kemiripan teks judul dan bukan merupakan analisis
                            plagiarisme yang komprehensif.
                            Untuk analisis yang lebih mendalam, disarankan menggunakan tools plagiarisme profesional yang
                            dapat menganalisis seluruh isi dokumen.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        // Initialize Feather Icons
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endsection
