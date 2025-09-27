<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                @php
                    $totalThesis = App\Models\Thesis::count();
                    $thisYearThesis = App\Models\Thesis::whereYear('created_at', date('Y'))->count();
                    $thesisTypes = App\Models\Thesis::selectRaw('type, COUNT(*) as count')
                        ->groupBy('type')
                        ->pluck('count', 'type')
                        ->toArray();
                @endphp

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-2 bg-indigo-500 rounded-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Tugas Akhir</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totalThesis }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-500 rounded-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Tahun {{ date('Y') }}</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $thisYearThesis }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-2 bg-purple-500 rounded-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Jenis Terbanyak</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ !empty($thesisTypes) ? ucfirst(array_keys($thesisTypes, max($thesisTypes))[0]) : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Selamat datang, {{ Auth::user()->name }}!</h3>

                    @if (Auth::user()->role === 'admin')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Menu Admin</h4>
                                <ul class="space-y-2">
                                    <li>
                                        <a href="{{ route('admin.thesis.index') }}"
                                            class="text-indigo-600 hover:text-indigo-900 hover:underline">
                                            Kelola Tugas Akhir
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.thesis.create') }}"
                                            class="text-indigo-600 hover:text-indigo-900 hover:underline">
                                            Tambah Tugas Akhir Baru
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Quick Stats</h4>
                                <ul class="space-y-2 text-sm text-gray-600">
                                    @foreach ($thesisTypes as $type => $count)
                                        <li>{{ ucfirst($type) }}: {{ $count }} buah</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @else
                        <div>
                            <p class="text-gray-600 mb-4">
                                Sistem Pengarsipan Tugas Akhir menyediakan akses mudah untuk mencari dan melihat koleksi
                                tugas akhir.
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-2">Fitur Tersedia</h4>
                                    <ul class="space-y-2 text-sm text-gray-600">
                                        <li>• Pencarian tugas akhir</li>
                                        <li>• Filter berdasarkan jenis dan tahun</li>
                                        <li>• Cek plagiarisme judul</li>
                                        <li>• Lihat detail dan abstrak</li>
                                    </ul>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-2">Menu Utama</h4>
                                    <ul class="space-y-2">
                                        <li>
                                            <a href="{{ route('public.thesis.index') }}"
                                                class="text-indigo-600 hover:text-indigo-900 hover:underline">
                                                Jelajahi Tugas Akhir
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('plagiarism.check') }}"
                                                class="text-indigo-600 hover:text-indigo-900 hover:underline">
                                                Cek Plagiarisme Judul
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
