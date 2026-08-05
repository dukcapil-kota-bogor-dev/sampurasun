<x-guest-layout>
    
    <div class="mb-8 flex flex-col items-center justify-center">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/Logo Dukcapil.png') }}" alt="Logo" class="h-12 w-auto">
            
            <h1 class="text-3xl font-bold text-gray-800 tracking-tight">
                SAMPURASUN
            </h1>
        </div>
    </div>

    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="font-semibold text-gray-700" />
            <x-text-input id="email" 
                class="block mt-1.5 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3 px-4 transition duration-150" 
                type="email" 
                name="email" 
                :value="old('email')" 
                placeholder="nama@email.com"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" class="font-semibold text-gray-700" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-indigo-600 hover:text-indigo-500 transition-colors" href="{{ route('password.request') }}">
                        {{ __('Lupa password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" 
                class="block mt-1.5 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3 px-4 transition duration-150"
                type="password"
                name="password"
                placeholder="••••••••"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-start mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 transition cursor-pointer" name="remember">
                <span class="ms-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">{{ __('Ingat saya di perangkat ini') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3.5 text-sm font-bold tracking-widest uppercase bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] transition-all duration-150 rounded-xl shadow-lg shadow-indigo-100">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>