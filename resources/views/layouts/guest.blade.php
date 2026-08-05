<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full overflow-hidden">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SAMPURASUN - Login</title>

        <link rel="icon" type="image/png" href="{{ asset('images/Logo Dukcapil.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <style>
            /* Utilitas tambahan untuk menyembunyikan scrollbar di semua browser */
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased h-full overflow-hidden no-scrollbar">
        <div class="h-screen w-full flex flex-col justify-center items-center relative bg-cover bg-center bg-no-repeat overflow-hidden px-4" 
             style="background-image: url('{{ asset('images/depan capil.jpeg') }}');">
            
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

            <div class="relative z-10 w-full flex flex-col items-center">

                <div class="w-full sm:max-w-[500px] px-6 py-8 sm:px-10 sm:py-12 bg-white/95 backdrop-blur shadow-2xl rounded-[2.5rem] border border-white/20 overflow-y-auto no-scrollbar max-h-[80vh]">
                    <div class="w-full">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>