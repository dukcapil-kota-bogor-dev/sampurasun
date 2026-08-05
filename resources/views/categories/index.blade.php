<x-app-layout>
    {{-- CSS Khusus untuk Font & Animasi --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            scroll-behavior: smooth;
        }

        /* Animasi Masuk Utama (Fade In Up) */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .category-card {
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            animation: fadeInUp 0.6s ease-out backwards;
        }

        /* Stagger Effect: Kartu muncul satu per satu */
        .category-card:nth-child(1) { animation-delay: 0.1s; }
        .category-card:nth-child(2) { animation-delay: 0.15s; }
        .category-card:nth-child(3) { animation-delay: 0.2s; }
        .category-card:nth-child(4) { animation-delay: 0.25s; }
        .category-card:nth-child(5) { animation-delay: 0.3s; }
        .category-card:nth-child(6) { animation-delay: 0.35s; }
        .category-card:nth-child(n+7) { animation-delay: 0.4s; }

        /* Efek saat kartu disembunyikan (Pencarian) */
        .card-hidden {
            opacity: 0 !important;
            transform: scale(0.8) translateY(20px) !important;
            pointer-events: none;
            position: absolute;
            z-index: -1;
        }

        /* Custom Scrollbar untuk tampilan lebih bersih */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #c7d2fe;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a5b4fc;
        }
    </style>

    <div class="py-6 md:py-10 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Konten --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8 md:mb-12">
                <div class="text-left animate-pulse-slow">
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                        Kategori <span class="text-indigo-600">Layanan</span>
                    </h1>
                    <p class="text-gray-500 mt-1 md:mt-2 text-sm md:text-base">
                        Pilih kategori untuk melihat detail dan statistik data secara real-time.
                    </p>
                </div>
                
                {{-- Search Bar dengan Animasi Fokus --}}
                <div class="relative w-full md:w-96 group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-indigo-600 transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input type="text" id="categorySearch" placeholder="Cari kategori layanan..." 
                        class="block w-full pl-12 pr-4 py-3 md:py-3.5 border-2 border-transparent bg-white rounded-2xl shadow-sm focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-300 text-sm text-gray-700 placeholder-gray-400">
                </div>
            </div>

            {{-- Grid Kategori --}}
            <div id="categoriesGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-8">
                @forelse($categories as $cat)
                    <div class="category-card group bg-white p-6 md:p-7 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-3" 
                        data-name="{{ strtolower($cat->name) }}">
                        
                        <div class="flex flex-col h-full">
                            {{-- Icon & Label --}}
                            <div class="flex items-center justify-between mb-6">
                                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center group-hover:rotate-12 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500 shadow-inner">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <div class="px-3 py-1 bg-gray-50 rounded-full text-[10px] font-black text-gray-400 uppercase tracking-widest group-hover:bg-indigo-50 group-hover:text-indigo-400 transition-colors">
                                    Layanan
                                </div>
                            </div>

                            {{-- Info Kategori --}}
                            <div class="flex-grow">
                                <h3 class="text-xl md:text-2xl font-extrabold text-gray-900 mb-2 truncate group-hover:text-indigo-600 transition-colors duration-300">
                                    {{ $cat->name }}
                                </h3>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-2xl md:text-3xl font-black text-indigo-600">{{ $cat->questions_count ?? 0 }}</span>
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Data</span>
                                </div>
                            </div>

                            {{-- Tombol Detail dengan Animasi Slide --}}
                            <div class="mt-8">
                                <a href="{{ route('categories.show', $cat->id) }}" 
                                   class="relative flex items-center justify-between w-full pl-6 pr-2 py-2 bg-gray-50 group-hover:bg-indigo-600 text-gray-700 group-hover:text-white font-bold rounded-2xl transition-all duration-500 overflow-hidden shadow-sm">
                                    <span class="text-sm md:text-base relative z-10 transition-transform duration-500 group-hover:translate-x-1">Lihat Detail</span>
                                    <div class="w-10 h-10 bg-white group-hover:bg-white/20 rounded-xl flex items-center justify-center text-indigo-600 group-hover:text-white transition-all duration-300 relative z-10 group-hover:rotate-[360deg]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Empty State --}}
                    <div class="col-span-full py-20 flex flex-col items-center justify-center bg-white rounded-[3rem] border-2 border-dashed border-gray-100 shadow-inner px-4 text-center animate-pulse">
                        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Menemukan Data</h3>
                        <p class="text-gray-400 text-sm max-w-xs">Belum ada kategori yang ditambahkan atau pencarian tidak cocok.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Script Pencarian Real-time yang Dihaluskan --}}
    <script>
        document.getElementById('categorySearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().trim();
            const cards = document.querySelectorAll('.category-card');
            
            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                
                if(name.includes(searchTerm)) {
                    // Tampilkan kembali
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.classList.remove('card-hidden');
                    }, 10);
                } else {
                    // Beri animasi keluar
                    card.classList.add('card-hidden');
                    // Tunggu animasi selesai baru display none
                    setTimeout(() => {
                        if(card.classList.contains('card-hidden')) {
                            card.style.display = 'none';
                        }
                    }, 500); 
                }
            });
        });
    </script>
</x-app-layout>