@extends('layouts.admin')

@section('title', 'Kelola Tugas Akhir - Admin')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold mb-2">Kelola Tugas Akhir</h1>
            <p class="text-xl text-white/80">Panel administrasi untuk mengelola data tugas akhir</p>
        </div>
        <a href="{{ route('admin.thesis.create') }}"
            class="px-6 py-3 bg-white/20 hover:bg-white/30 text-white border border-white/30 rounded-lg transition-colors flex items-center">
            <i data-feather="plus" class="w-5 h-5 mr-2"></i>
            Tambah Tugas Akhir
        </a>
    </div>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        @php
            $totalThesis = $theses->total();
            $filteredCount = $theses->count();
            $skripsiCount = App\Models\Thesis::where('type', 'skripsi')->count();
            $tesisCount = App\Models\Thesis::where('type', 'tesis')->count();
        @endphp

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-500 rounded-lg">
                    <i data-feather="database" class="w-6 h-6 text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Data</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalThesis }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-500 rounded-lg">
                    <i data-feather="filter" class="w-6 h-6 text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Hasil Filter</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $filteredCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-500 rounded-lg">
                    <i data-feather="book" class="w-6 h-6 text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Skripsi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $skripsiCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-orange-500 rounded-lg">
                    <i data-feather="award" class="w-6 h-6 text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tesis</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $tesisCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i data-feather="search" class="w-5 h-5 mr-2"></i>
                Filter & Pencarian Data
            </h3>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('admin.thesis.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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

                <div class="flex items-end space-x-2">
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors flex items-center justify-center">
                        <i data-feather="filter" class="w-4 h-4 mr-2"></i>
                        Filter
                    </button>
                    <a href="{{ route('admin.thesis.index') }}"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg transition-colors">
                        <i data-feather="refresh-cw" class="w-4 h-4"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i data-feather="list" class="w-5 h-5 mr-2"></i>
                    Data Tugas Akhir
                </h3>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">
                        Menampilkan {{ $theses->firstItem() ?? 0 }} - {{ $theses->lastItem() ?? 0 }} dari
                        {{ $theses->total() }} data
                    </span>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Judul & Penulis
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jenis
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Program Studi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tahun
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($theses as $thesis)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="max-w-xs">
                                    <div class="text-sm font-medium text-gray-900 line-clamp-2">
                                        {{ $thesis->title }}
                                    </div>
                                    <div class="text-sm text-gray-500 flex items-center mt-1">
                                        <i data-feather="user" class="w-3 h-3 mr-1"></i>
                                        {{ $thesis->author }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $thesis->type === 'skripsi' ? 'bg-blue-100 text-blue-800' : ($thesis->type === 'tesis' ? 'bg-purple-100 text-purple-800' : 'bg-orange-100 text-orange-800') }}">
                                    {{ ucfirst($thesis->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs">
                                    {{ $thesis->program_study }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="flex items-center">
                                    <i data-feather="calendar" class="w-4 h-4 mr-1 text-gray-400"></i>
                                    {{ $thesis->year }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i data-feather="check-circle" class="w-3 h-3 mr-1"></i>
                                    Aktif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.thesis.show', $thesis) }}"
                                        class="p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Lihat Detail">
                                        <i data-feather="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('admin.thesis.edit', $thesis) }}"
                                        class="p-2 text-yellow-600 hover:text-yellow-900 hover:bg-yellow-50 rounded-lg transition-colors"
                                        title="Edit">
                                        <i data-feather="edit-2" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.thesis.destroy', $thesis) }}" method="POST"
                                        class="inline" onsubmit="return confirmDelete('{{ $thesis->title }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Hapus">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i data-feather="database" class="w-12 h-12 text-gray-400 mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data</h3>
                                    <p class="text-gray-500 mb-6">Belum ada tugas akhir yang sesuai dengan filter yang
                                        dipilih.</p>
                                    <a href="{{ route('admin.thesis.create') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-blue-700 bg-blue-100 hover:bg-blue-200 transition-colors">
                                        <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                                        Tambah Tugas Akhir Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($theses->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $theses->withQueryString()->links() }}
            </div>
        @endif
    </div>

    <script>
        // Initialize Feather Icons
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });

        function confirmDelete(title) {
            return confirm(`Apakah Anda yakin ingin menghapus tugas akhir "${title}"?\n\nAksi ini tidak dapat dibatalkan.`);
        }
    </script>
@endsection
