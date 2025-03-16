<x-guest-layout>
    <!-- Títol amb animació -->
    <div class="text-center mb-6 animate-fade-in-down">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">{{ __('Registre d\'Usuari') }}</h1>
    </div>

    <!-- Formulari -->
    <form method="POST" action="{{ route('register') }}" class="animate-fade-in-up">
        @csrf

        <!-- Nom -->
        <div class="mb-4">
            <x-input-label for="first_name" :value="__('Nom')" />
            <x-text-input id="first_name" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500"
                          type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Cognoms -->
        <div class="mb-4">
            <x-input-label for="last_name" :value="__('Cognoms')" />
            <x-text-input id="last_name" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500"
                          type="text" name="last_name" :value="old('last_name')" required autocomplete="last_name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Nom d'Usuari -->
        <div class="mb-4">
            <x-input-label for="username" :value="__('Nom d\'usuari')" />
            <x-text-input id="username" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500"
                          type="text" name="username" :value="old('username')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500"
                          type="email" name="email" :value="old('email')" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Telèfon -->
        <div class="mb-4">
            <x-input-label for="phone" :value="__('Telèfon (Opcional)')" />
            <x-text-input id="phone" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500"
                          type="text" name="phone" :value="old('phone')" autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Contrasenya -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Contrasenya')" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500"
                          type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar Contrasenya -->
        <div class="mb-4">
            <x-input-label for="password_confirmation" :value="__('Confirma la contrasenya')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500"
                          type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Botons -->
        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-blue-500 transition">
                {{ __('Ja tens compte?') }}
            </a>
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded transition">
                {{ __('Registra\'t') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Animacions -->
    <style>
        @keyframes fade-in-down {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.8s ease-out;
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out;
        }
    </style>
</x-guest-layout>
