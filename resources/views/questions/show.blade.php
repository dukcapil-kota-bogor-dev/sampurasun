<x-app-layout>
    <x-slot name="title">
        Detail Pertanyaan
    </x-slot>

    <div class="py-6 overflow-hidden"> 
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-5 bg-white">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-3 mb-4 gap-2">
                        <div>
                            <h1 class="text-xl font-bold text-gray-800">Detail Pertanyaan</h1>
                            <p class="text-xs text-gray-500 mt-0.5">Informasi lengkap data pertanyaan masuk</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                ID: #{{ $question->id }}
                            </span>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        @include('questions._detail', ['question' => $question])
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <a href="{{ route('questions.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                        
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('questions.edit', $question->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out shadow-sm">
                                <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                                Edit Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            overflow-y: auto; /* Scrollbar utama tetap ada jika halaman panjang */
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE/Edge */
        }
        body::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
        
        /* Jika di dalam _detail ada tabel atau textarea yang menyebabkan scroll */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</x-app-layout>