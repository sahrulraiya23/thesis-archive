@extends('layouts.admin')

@section('title', $thesis->title)

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold mb-2">Detail Tugas Akhir</h1>
            <p class="text-xl text-white/80">{{ $thesis->type }} - {{ $thesis->year }}</p>
        </div>
        <a href="{{ route('public.thesis.index') }}"
            class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white border border-white/30 rounded-lg transition-colors flex items-center">
            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
            Kembali
        </a>
    </div>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <!-- Header Section -->
            <div class="p-8 border-b border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ ucfirst($thesis->type) }}
                        </span>
                        <span class="text-gray-500 flex items-center">
                            <i data-feather="calendar" class="w-4 h-4 mr-1"></i>
                            {{ $thesis->year }}
                        </span>
                        <span class="text-gray-500 flex items-center">
                            <i data-feather="clock" class="w-4 h-4 mr-1"></i>
                            {{ $thesis->created_at->format('d M Y') }}
                        </span>
                    </div>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-6">
                    {{ $thesis->title }}
                </h1>

                <!-- Author & Program Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <i data-feather="user" class="w-6 h-6 text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Penulis</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $thesis->author }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-green-500 to-teal-600 rounded-lg flex items-center justify-center">
                            <i data-feather="book-open" class="w-6 h-6 text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Program Studi</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $thesis->program_study }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Abstract Section -->
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    <i data-feather="file-text" class="w-6 h-6 mr-2"></i>
                    Abstrak
                </h2>
                <div class="prose max-w-none">
                    <div class="text-gray-700 leading-relaxed text-justify bg-gray-50 p-6 rounded-lg">
                        {!! nl2br(e($thesis->abstract)) !!}
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="p-8 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('plagiarism.check') }}?title={{ urlencode($thesis->title) }}"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 transition-all duration-200">
                        <i data-feather="shield" class="w-5 h-5 mr-2"></i>
                        Cek Plagiarisme Judul Ini
                    </a>

                    <button onclick="window.print()"
                        class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <i data-feather="printer" class="w-5 h-5 mr-2"></i>
                        Print Detail
                    </button>

                    <button onclick="sharePage()"
                        class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <i data-feather="share-2" class="w-5 h-5 mr-2"></i>
                        Share
                    </button>
                </div>
            </div>
        </div>

        <!-- Related or Similar Thesis -->
        <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i data-feather="book" class="w-5 h-5 mr-2"></i>
                    Tugas Akhir Sejenis
                </h3>
            </div>
            <div class="p-6">
                @php
                    $similarTheses = App\Models\Thesis::where('type', $thesis->type)
                        ->where('id', '!=', $thesis->id)
                        ->latest()
                        ->limit(3)
                        ->get();
                @endphp

                @if ($similarTheses->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach ($similarTheses as $similar)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <h4 class="font-medium text-gray-900 mb-2 line-clamp-2">
                                    <a href="{{ route('public.thesis.show', $similar) }}" class="hover:text-blue-600">
                                        {{ Str::limit($similar->title, 80) }}
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-600 mb-2">{{ $similar->author }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $similar->year }}</span>
                                    <a href="{{ route('public.thesis.show', $similar) }}"
                                        class="text-xs text-blue-600 hover:text-blue-800">
                                        Lihat →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Tidak ada tugas akhir sejenis lainnya.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Initialize Feather Icons
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });

        function sharePage() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $thesis->title }}',
                    text: 'Lihat tugas akhir: {{ $thesis->title }} oleh {{ $thesis->author }}',
                    url: window.location.href
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(function() {
                    alert('Link telah disalin ke clipboard!');
                });
            }
        }
    </script>
@endsection
