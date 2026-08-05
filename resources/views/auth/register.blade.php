<x-guest-layout>
    <div class="mb-6 sm:mb-8 flex flex-col items-center justify-center">
        <div class="flex items-center gap-2 sm:gap-3">
            <img src="{{ asset('images/Logo Dukcapil.png') }}" alt="Logo" class="h-10 sm:h-12 w-auto">
            
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">
                SAMPURASUN
            </h1>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-sm font-semibold text-gray-700" />
            <x-text-input id="name" 
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-2.5 sm:py-3 px-4 text-sm transition duration-150" 
                type="text" 
                name="name" 
                :value="old('name')" 
                placeholder="Nama lengkap"
                required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-700" />
            <x-text-input id="email" 
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-2.5 sm:py-3 px-4 text-sm transition duration-150" 
                type="email" 
                name="email" 
                :value="old('email')" 
                placeholder="nama@email.com"
                required />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-700" />
                <x-text-input id="password" 
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-2.5 sm:py-3 px-4 text-sm transition duration-150"
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Konfirmasi')" class="text-sm font-semibold text-gray-700" />
                <x-text-input id="password_confirmation" 
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-2.5 sm:py-3 px-4 text-sm transition duration-150"
                    type="password"
                    name="password_confirmation" 
                    placeholder="••••••••"
                    required />
            </div>
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-1" />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3 sm:py-3.5 text-xs sm:text-sm font-bold tracking-widest uppercase bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] transition-all duration-150 rounded-xl shadow-lg shadow-indigo-100">
                {{ __('Daftar Sekarang') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>