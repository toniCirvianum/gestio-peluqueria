<div class="border rounded-lg p-4 shadow-md bg-white dark:bg-gray-800">
    <div class="flex justify-between items-center">
        <!-- Dades de l'usuari -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                {{ $user->first_name }} {{ $user->last_name }}
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Email:') }} {{ $user->email }}
            </p>
            @if($user->phone)
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Telèfon:') }} {{ $user->phone }}
                </p>
            @endif
        </div>

        <div class="flex items-center gap-2">
            <!-- Botó Editar: Només es mostra a clients.index -->
            @if (Route::currentRouteName() == 'clients.index')
                <a href="{{ route('clients.edit', ['id' => $user->id]) }}"
                   class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                    {{ __('Editar') }}
                </a>
            @endif

            <!-- Botó Eliminar: Només per admins -->
            @if (auth()->user()->role->name === 'admin')
                <form
                    action="{{ Route::currentRouteName() == 'clients.index'
                        ? route('clients.destroy', ['id' => $user->id])
                        : route('workers.destroy', ['id' => $user->id]) }}"
                    method="POST"
                    onsubmit="return confirm('Segur que vols eliminar aquest usuari?')"
                >
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                        {{ __('Eliminar') }}
                    </button>
                </form>
            @endif
        </div>

    </div>
</div>
