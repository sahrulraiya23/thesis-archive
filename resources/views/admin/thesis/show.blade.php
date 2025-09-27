<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Tugas Akhir (Admin)
            </h2>
            <div class="space-x-2">
                <a href="{{ route('admin.thesis.edit', $thesis) }}"
                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('admin.thesis.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header Info -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                    {{ ucfirst($thesis->type) }}
                                </span>
                                <span class="ml-3 text-sm text-gray-500">{{ $thesis->year }}</span>
                            </div>
                            <div class="text-sm text-gray-500">
                                Dibuat: {{ $thesis->created_at->format('d M Y H:i') }}
                            </div>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">
                            {{ $thesis->title }}
                        </h1>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Penulis</p>
                                <p class="text-lg text-gray-900">{{ $thesis->author }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Program Studi</p>
                                <p class="text-lg text-gray-900">{{ $thesis->program_study }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Abstract -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Abstrak</h2>
                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($thesis->abstract)) !!}
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex justify-between">
                            <form action="{{ route('admin.thesis.destroy', $thesis) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus tugas akhir ini? Aksi ini tidak dapat dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Hapus Tugas Akhir
                                </button>
                            </form>

                            <a href="{{ route('public.thesis.show', $thesis) }}" target="_blank"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Lihat di Halaman Publik
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
