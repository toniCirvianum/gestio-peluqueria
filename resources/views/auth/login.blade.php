<x-guest-layout>
    <div class="text-center mb-6 animate-fade-in-down">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">{{ __('Iniciar Sessió') }}</h1>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Formulari -->
    <form method="POST" action="{{ route('login') }}" class="animate-fade-in-up">
        @csrf

        <!-- Email o Usuari -->
        <div class="mb-4">
            <x-input-label for="login" :value="__('Usuari o email')" />
            <x-text-input id="login"
                          class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500"
                          type="text"
                          name="login"
                          :value="old('login')"
                          required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Contrasenya')" />
            <x-text-input id="password"
                          class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mb-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me"
                       type="checkbox"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                       name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Recorda\'m') }}</span>
            </label>
        </div>

        <!-- Botons -->
        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-blue-500 transition">
                {{ __('No tens compte?') }}
            </a>
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded transition">
                {{ __('Iniciar Sessió') }}
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
