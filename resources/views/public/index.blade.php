@extends('layouts.admin')

@section('title', 'Daftar Tugas Akhir')

@section('header')
    <h1 class="text-4xl font-bold mb-2">Daftar Tugas Akhir</h1>
    <p class="text-xl text-white/80">Jelajahi koleksi tugas akhir mahasiswa</p>
@endsection

@section('content')
    <!-- Filter Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i data-feather="filter" class="w-5 h-5 mr-2"></i>
                Filter & Pencarian
            </h3>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('public.thesis.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Judul atau Penulis"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-feather="search" class="w-4 h-4 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Jenis</label>
                    <select name="type" id="type"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Jenis</option>
                        @foreach ($types as $key => $value)
                            <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                    <select name="year" id="year"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Tahun</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors flex items-center justify-center">
                        <i data-feather="filter" class="w-4 h-4 mr-2"></i>
                        Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Info -->
    <div class="mb-6">
        <p class="text-gray-600">
            Menampilkan {{ $theses->count() }} dari {{ $theses->total() }} tugas akhir
        </p>
    </div>

    <!-- Thesis Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
        @forelse($theses as $thesis)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-4">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ ucfirst($thesis->type) }}
                        </span>
                        <span class="text-sm text-gray-500 flex items-center">
                            <i data-feather="calendar" class="w-4 h-4 mr-1"></i>
                            {{ $thesis->year }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h3 class="text-lg font-semibold text-gray-900 mb-3 line-clamp-2">
                        <a href="{{ route('public.thesis.show', $thesis) }}" class="hover:text-blue-600 transition-colors">
                            {{ $thesis->title }}
                        </a>
                    </h3>

                    <!-- Author Info -->
                    <div class="space-y-2 mb-4">
                        <p class="text-sm text-gray-600 flex items-center">
                            <i data-feather="user" class="w-4 h-4 mr-2"></i>
                            <strong>{{ $thesis->author }}</strong>
                        </p>
                        <p class="text-sm text-gray-600 flex items-center">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i>
                            {{ $thesis->program_study }}
                        </p>
                    </div>

                    <!-- Abstract Preview -->
                    <p class="text-gray-700 text-sm line-clamp-3 mb-4">
                        {{ Str::limit($thesis->abstract, 150) }}
                    </p>

                    <!-- Action Button -->
                    <div class="pt-4 border-t border-gray-100">
                        <a href="{{ route('public.thesis.show', $thesis) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-blue-700 bg-blue-100 hover:bg-blue-200 transition-colors w-full justify-center">
                            <i data-feather="eye" class="w-4 h-4 mr-2"></i>
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                    <i data-feather="search" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada tugas akhir ditemukan</h3>
                    <p class="text-gray-600">Coba ubah filter pencarian atau hapus beberapa filter.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($theses->hasPages())
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            {{ $theses->withQueryString()->links() }}
        </div>
    @endif

    <script>
        // Initialize Feather Icons after page load
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endsection
