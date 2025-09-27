@extends('layouts.admin')

@section('title', 'Dashboard - Sistem Pengarsipan Tugas Akhir')

@section('header')
    <h1 class="text-4xl font-bold mb-2">Selamat Datang Di Sistem Pengarsipan Tugas Akhir</h1>
    <p class="text-xl text-white/80">Teknik Informatika - Universitas Halu Oleo</p>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Dashboard Overview</h2>
        <p class="text-gray-600">Ringkasan sistem pengarsipan tugas akhir</p>
        <hr class="my-4 border-gray-300">
    </div>

    @php
        $totalThesis = App\Models\Thesis::count();
        $thisYearThesis = App\Models\Thesis::whereYear('created_at', date('Y'))->count();
        $thesisTypes = App\Models\Thesis::selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();
        $recentThesis = App\Models\Thesis::latest()->limit(5)->get();
    @endphp

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Tugas Akhir -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-500 rounded-lg">
                    <i data-feather="book" class="w-6 h-6 text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Tugas Akhir</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalThesis }}</p>
                </div>
            </div>
        </div>

        <!-- Tahun Ini -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-500 rounded-lg">
                    <i data-feather="calendar" class="w-6 h-6 text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tahun {{ date('Y') }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $thisYearThesis }}</p>
                </div>
            </div>
        </div>

        <!-- Skripsi -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-500 rounded-lg">
                    <i data-feather="file-text" class="w-6 h-6 text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Skripsi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $thesisTypes['skripsi'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Tesis -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-orange-500 rounded-lg">
                    <i data-feather="award" class="w-6 h-6 text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tesis</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $thesisTypes['tesis'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Thesis -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i data-feather="clock" class="w-5 h-5 mr-2"></i>
                        Tugas Akhir Terbaru
                    </h3>
                </div>
                <div class="p-6">
                    @if ($recentThesis->count() > 0)
                        <div class="space-y-4">
                            @foreach ($recentThesis as $thesis)
                                <div class="flex items-start space-x-4 p-4 hover:bg-gray-50 rounded-lg transition-colors">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                            <i data-feather="file-text" class="w-5 h-5 text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium text-gray-900 mb-1">
                                            <a href="{{ route('public.thesis.show', $thesis) }}"
                                                class="hover:text-blue-600 transition-colors">
                                                {{ Str::limit($thesis->title, 80) }}
                                            </a>
                                        </h4>
                                        <p class="text-sm text-gray-600 mb-2">
                                            {{ $thesis->author }} • {{ $thesis->program_study }}
                                        </p>
                                        <div class="flex items-center space-x-3">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ ucfirst($thesis->type) }}
                                            </span>
                                            <span class="text-xs text-gray-500">{{ $thesis->year }}</span>
                                            <span
                                                class="text-xs text-gray-500">{{ $thesis->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 text-center">
                            <a href="{{ route('public.thesis.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 transition-colors">
                                Lihat Semua Tugas Akhir
                                <i data-feather="arrow-right" class="w-4 h-4 ml-2"></i>
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i data-feather="book" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                            <p class="text-gray-500">Belum ada tugas akhir yang tersedia</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions & Stats -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i data-feather="zap" class="w-5 h-5 mr-2"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <a href="{{ route('public.thesis.index') }}"
                            class="flex items-center p-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                            <i data-feather="search" class="w-4 h-4 mr-3 text-blue-500"></i>
                            Jelajahi Tugas Akhir
                        </a>
                        <a href="{{ route('plagiarism.check') }}"
                            class="flex items-center p-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                            <i data-feather="shield" class="w-4 h-4 mr-3 text-green-500"></i>
                            Cek Plagiarisme Judul
                        </a>
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.thesis.create') }}"
                                class="flex items-center p-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                <i data-feather="plus" class="w-4 h-4 mr-3 text-purple-500"></i>
                                Tambah Tugas Akhir
                            </a>
                            <a href="{{ route('admin.thesis.index') }}"
                                class="flex items-center p-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                <i data-feather="settings" class="w-4 h-4 mr-3 text-orange-500"></i>
                                Kelola Data
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Distribution Chart -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i data-feather="pie-chart" class="w-5 h-5 mr-2"></i>
                        Distribusi Jenis
                    </h3>
                </div>
                <div class="p-6">
                    @if (!empty($thesisTypes))
                        <div class="space-y-4">
                            @foreach ($thesisTypes as $type => $count)
                                @php
                                    $percentage = $totalThesis > 0 ? round(($count / $totalThesis) * 100, 1) : 0;
                                @endphp
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-medium text-gray-900">{{ ucfirst($type) }}</span>
                                        <span class="text-sm text-gray-600">{{ $count }}
                                            ({{ $percentage }}%)</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full transition-all duration-500"
                                            style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-500 text-sm">Tidak ada data untuk ditampilkan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
