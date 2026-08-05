<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SAMPURASUN</title>

        <link rel="icon" type="image/png" href="{{ asset('images/Logo Dukcapil.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Menghilangkan scrollbar utama */
            html, body {
                scrollbar-width: none;
                -ms-overflow-style: none;
            }
            
            body::-webkit-scrollbar {
                display: none;
            }

            /* Efek Glassmorphism Sebening Kristal */
            .glass-header {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }

            /* Gradient teks untuk judul */
            .header-title-gradient {
                background: linear-gradient(to right, #1e293b, #4f46e5);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            /* Transisi Avatar */
            .avatar-ring {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .avatar-btn:hover .avatar-ring {
                border-color: #4f46e5;
                transform: scale(1.05);
                box-shadow: 0 4px 15px rgba(79, 70, 229, 0.15);
            }
        </style>

        <script>
            window.baseUrl = "{{ url('') }}";
        </script>
    </head>
    <body class="font-sans antialiased text-slate-900 bg-slate-50">
        <div class="min-h-screen flex flex-col lg:flex-row">
            {{-- Navigasi Sidebar & Mobile Header --}}
            @include('layouts.navigation')

            {{-- Main Content Container --}}
            <div class="flex-1 lg:pl-64 pt-16 lg:pt-0 transition-all duration-300 w-full">
                
                {{-- Header Page --}}
                {{-- PERUBAHAN: h-20 agar sama dengan tinggi logo sidebar, border-gray-50 agar identik --}}
                <header class="glass-header sticky top-16 lg:top-0 z-30 h-20 border-b border-gray-50 flex items-center shadow-none">
                    <div class="w-full max-w-7xl mx-auto px-6 sm:px-8 flex justify-between items-center">
                        
                        {{-- Bagian Kiri: Judul Halaman --}}
                        <div class="flex flex-col">
                            <h2 class="font-extrabold text-2xl tracking-tight leading-none header-title-gradient">
                                @isset($header)
                                    {{ $header }}
                                @else
                                    @yield('header')
                                @endisset
                            </h2>
                        </div>

                        {{-- Bagian Kanan: Informasi Akun --}}
                        <div class="flex items-center gap-4">
                            <div class="hidden md:flex flex-col text-right leading-tight">
                                <span class="text-base font-bold text-slate-800">
                                    {{ Auth::user()->name }}
                                </span>
                                <span class="text-[11px] font-bold text-indigo-600 uppercase tracking-widest flex items-center justify-end mt-1">
                                    <span class="h-2 w-2 rounded-full bg-indigo-500 mr-2 animate-pulse"></span>
                                    {{ Auth::user()->role ?? 'Administrator' }}
                                </span>
                            </div>

                            {{-- Avatar --}}
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="avatar-btn flex items-center focus:outline-none group">
                                    <div class="avatar-ring h-10 w-10 rounded-full border-2 border-slate-200 p-0.5 overflow-hidden bg-white shadow-sm">
                                        @if(Auth::user()->profile_photo_url)
                                            <img src="{{ Auth::user()->profile_photo_url }}" class="h-full w-full rounded-full object-cover" alt="Avatar">
                                        @else
                                            <div class="h-full w-full rounded-full bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white text-[10px] font-black">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                </button>

                                {{-- Dropdown --}}
                                <div x-show="open" 
                                     @click.outside="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl py-2 border border-slate-200 z-50 overflow-hidden"
                                     style="display: none;">
                                    
                                    <a href="{{ route('profile.edit') }}" class="group flex items-center px-4 py-2.5 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-700 transition-all font-semibold">
                                        <svg class="w-4 h-4 mr-3 text-slate-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Pengaturan Profil
                                    </a>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="group flex items-center w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-all font-bold border-t border-slate-50 mt-1">
                                            <svg class="w-4 h-4 mr-3 text-red-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Keluar Aplikasi
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                {{-- Slot Konten Utama --}}
                <main class="py-8 px-4 sm:px-6 lg:px-8">
                    <div class="max-w-7xl mx-auto">
                        @isset($slot)
                            {{ $slot }}
                        @else
                            @yield('content')
                        @endisset
                    </div>
                </main>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>