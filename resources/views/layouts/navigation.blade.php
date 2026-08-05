<div x-data="{ open: false }">
    {{-- 1. Mobile Top Bar (Hanya muncul di layar < 1024px) --}}
    <div class="lg:hidden fixed top-0 left-0 right-0 h-16 bg-white border-b border-gray-100 flex items-center justify-between px-4 z-40 shadow-sm">
        <div class="flex items-center gap-3">
            <x-application-logo class="h-8 w-auto text-indigo-600" />
        </div>
        
        {{-- Tombol Hamburger --}}
        <button @click="open = !open" class="p-2 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all active:scale-90">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- 2. Overlay Backdrop (Mobile) --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="open = false" 
         class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 lg:hidden"
         style="display: none;">
    </div>

    {{-- 3. Sidebar Utama --}}
    <nav :class="open ? 'translate-x-0' : '-translate-x-full'" 
         class="fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-100 z-50 shadow-sm flex flex-col transform lg:translate-x-0 transition-transform duration-300 ease-in-out">
        
        {{-- Logo Section --}}
        <div class="flex items-center h-20 px-6 border-b border-gray-50 shrink-0">
            <div class="flex items-center gap-3">
                <x-application-logo class="h-9 w-auto text-indigo-600" />
            </div>
        </div>

        {{-- Menu Links --}}
        <div class="flex-1 px-4 py-6 overflow-y-auto custom-scrollbar">
            <div class="space-y-1.5">
                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}" 
                    class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"></path>
                    </svg>
                    {{ __('Dashboard') }}
                </a>

                {{-- Label Manajemen Data --}}
                <div class="pt-6 pb-2 px-3 text-[10px] font-semibold uppercase tracking-[0.1em] text-slate-400">
                    Manajemen Data
                </div>

                {{-- Daftar Pertanyaan --}}
                <a href="{{ route('questions.index') }}" 
                    class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('questions.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('questions.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5l3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    {{ __('Daftar Pertanyaan') }}
                </a>

                {{-- Kategori Layanan --}}
                <a href="{{ route('categories.index') }}" 
                    class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('categories.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                    {{ __('Kategori Layanan') }}
                </a>
            </div>
        </div>
    </nav>
</div>

<style>
    /* Haluskan Scrollbar Sidebar */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
</style>