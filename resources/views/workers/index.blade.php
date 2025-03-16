<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Llista d\'Usuaris') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Formulari de filtres -->
                <form method="GET" action="{{ route('workers.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Filtre per nom -->
                    <div>
                        <label for="name" class="block text-gray-700 dark:text-gray-300">{{ __('Nom') }}</label>
                        <input type="text" name="name" id="name" value="{{ request('name') }}" placeholder="Cerca per nom" class="w-full mt-1 border-gray-300 rounded">
                    </div>

                    <!-- Filtre per email -->
                    <div>
                        <label for="email" class="block text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                        <input type="text" name="email" id="email" value="{{ request('email') }}" placeholder="Cerca per email" class="w-full mt-1 border-gray-300 rounded">
                    </div>

                    <!-- Botó de filtre -->
                    <div class="col-span-1 md:col-span-3 flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">{{ __('Filtrar') }}</button>
                    </div>
                </form>

                <!-- Llista d'usuaris -->

                <h3 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Usuaris</h3>


                @if ($workers->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">No s'ha trobat cap usuari.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($workers as $user)
                            <x-user-card :user="$user" />
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
