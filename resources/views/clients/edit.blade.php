<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Client') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Editar Usuari</h3>

                <form method="POST" action="{{ route('clients.update', $client->id) }}">
                    @csrf
                    @method('PATCH')

                    <!-- First Name -->
                    <div class="mb-4">
                        <label for="first_name" class="block text-gray-700 dark:text-gray-300">{{ __('Nom') }}</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $client->first_name) }}" class="w-full mt-1 border-gray-300 rounded">
                        @error('first_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="mb-4">
                        <label for="last_name" class="block text-gray-700 dark:text-gray-300">{{ __('Cognoms') }}</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $client->last_name) }}" class="w-full mt-1 border-gray-300 rounded">
                        @error('last_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $client->email) }}" class="w-full mt-1 border-gray-300 rounded">
                        @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 dark:text-gray-300">{{ __('Telèfon') }}</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $client->phone) }}" class="w-full mt-1 border-gray-300 rounded">
                        @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Botó Actualitzar -->
                    <div class="flex items-center justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            {{ __('Actualitzar') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
