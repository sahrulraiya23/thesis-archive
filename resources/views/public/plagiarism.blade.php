<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cek Plagiarisme Judul') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Form Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="POST" action="{{ route('plagiarism.submit') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Masukkan Judul Tugas Akhir
                            </label>
                            <textarea name="title" id="title" rows="3"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-300 @enderror"
                                placeholder="Masukkan judul tugas akhir yang akan dicek..." required>{{ old('title', $inputTitle ?? '') }}</textarea>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"> Cek Plagiarisme</button>


                        </button>
                    </form>
                </div>
            </div>

            @if (isset($inputTitle))
                <!-- Results Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Hasil Pengecekan</h3>

                        <!-- Overall Result -->
                        <div
                            class="border rounded-lg p-4 mb-6 {{ $maxSimilarity > 70 ? 'bg-red-50 border-red-200' : ($maxSimilarity > 30 ? 'bg-yellow-50 border-yellow-200' : 'bg-green-50 border-green-200') }}">
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <h4
                                        class="text-lg font-medium {{ $maxSimilarity > 70 ? 'text-red-800' : ($maxSimilarity > 30 ? 'text-yellow-800' : 'text-green-800') }}">
                                        Tingkat Kemiripan Tertinggi: {{ number_format($maxSimilarity, 1) }}%
                                    </h4>
                                    <p
                                        class="text-sm {{ $maxSimilarity > 70 ? 'text-red-600' : ($maxSimilarity > 30 ? 'text-yellow-600' : 'text-green-600') }}">
                                        @if ($maxSimilarity > 70)
                                            Tingkat kemiripan tinggi - perlu revisi signifikan
                                        @elseif($maxSimilarity > 30)
                                            Tingkat kemiripan sedang - perlu perhatian
                                        @else
                                            Tingkat kemiripan rendah - relatif aman
                                        @endif
                                    </p>
                                </div>
                                <div class="text-right">
                                    <div
                                        class="text-2xl font-bold {{ $maxSimilarity > 70 ? 'text-red-600' : ($maxSimilarity > 30 ? 'text-yellow-600' : 'text-green-600') }}">
                                        {{ number_format($maxSimilarity, 1) }}%
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Results -->
                        @if (!empty($similarities))
                            <h4 class="text-md font-semibold text-gray-900 mb-3">Daftar Judul dengan Kemiripan:</h4>
                            <div class="space-y-3">
                                @foreach ($similarities as $similarity)
                                    @if ($similarity['percentage'] > 10)
                                        {{-- Only show similarities above 10% --}}
                                        <div
                                            class="border rounded-lg p-4 {{ $similarity['percentage'] > 70 ? 'bg-red-50 border-red-200' : ($similarity['percentage'] > 30 ? 'bg-yellow-50 border-yellow-200' : 'bg-gray-50 border-gray-200') }}">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1 pr-4">
                                                    <h5 class="font-medium text-gray-900 mb-1">
                                                        {{ $similarity['thesis']->title }}
                                                    </h5>
                                                    <p class="text-sm text-gray-600">
                                                        Penulis: {{ $similarity['thesis']->author }} |
                                                        {{ ucfirst($similarity['thesis']->type) }} |
                                                        {{ $similarity['thesis']->year }}
                                                    </p>
                                                    <p class="text-sm text-gray-600 mt-1">
                                                        Program Studi: {{ $similarity['thesis']->program_study }}
                                                    </p>
                                                </div>
                                                <div class="text-right">
                                                    <div
                                                        class="text-lg font-semibold {{ $similarity['percentage'] > 70 ? 'text-red-600' : ($similarity['percentage'] > 30 ? 'text-yellow-600' : 'text-gray-600') }}">
                                                        {{ number_format($similarity['percentage'], 1) }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6">
                                <p class="text-gray-500">Tidak ditemukan kemiripan yang signifikan dengan judul yang
                                    ada.</p>
                            </div>
                        @endif

                        <!-- Disclaimer -->
                        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-blue-800">
                                <strong>Catatan:</strong> Hasil pengecekan ini hanya berdasarkan kemiripan teks judul
                                dan bukan merupakan analisis plagiarisme yang komprehensif.
                                Untuk analisis yang lebih mendalam, disarankan menggunakan tools plagiarisme
                                profesional.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
