<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Tugas Akhir
            </h2>
            <a href="{{ route('public.thesis.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header Info -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <div class="flex items-center mb-4">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                {{ ucfirst($thesis->type) }}
                            </span>
                            <span class="ml-3 text-sm text-gray-500">{{ $thesis->year }}</span>
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
