    <x-app-layout>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6 pt-10">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Editar Reserva</h1>

                @if (session('success'))
                    <div class="p-4 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="id" value="{{ $reservation->id }}">

                    @if(!$reservation->client)

                        <div class="mb-4">
                            <label for="client_name" class="block text-gray-700">Nom del client</label>
                            <input
                                type="text"
                                id="client_name"
                                name="client_name"
                                class="w-full border border-gray-300 rounded p-2"
                                value="{{ $reservation->client_name ?? '' }}"
                                placeholder="Escriu el nom del client..."
                            />
                        </div>
                        <div class="mb-4">
                            <label for="client_phone" class="block text-gray-700">Telèfon</label>
                            <input
                                type="text"
                                id="client_phone"
                                name="client_phone"
                                class="w-full border border-gray-300 rounded p-2"
                                value="{{ $reservation->client_phone ?? '' }}"
                                placeholder="Escriu el telèfon..."
                            />
                        </div>
                    @else
                        <div class="mb-4">
                            <label for="client_id" class="block text-gray-700">Selecciona un client</label>
                            <input
                                type="text"
                                list="clients"
                                id="client_id_input"
                                name="client_id_name"
                                class="w-full border border-gray-300 rounded p-2"
                                value="{{ $reservation->client->first_name . ' ' . $reservation->client->last_name ?? '' }}"
                                placeholder="Cerca un client registrat..."
                                autocomplete="off"
                            />
                            <datalist id="clients">
                                @foreach ($clients as $client)
                                    <option data-id="{{ $client->id }}" value="{{ $client->first_name . ' ' . $client->last_name }}"></option>
                                @endforeach
                            </datalist>

                            <!-- Input hidden per enviar l'ID real del client -->
                            <input type="hidden" id="client_id" name="client_id" value="{{ $reservation->client_id }}">
                        </div>
                    @endif

                    <div class="mb-4">
                        <label for="worker_id" class="block text-gray-700">Selecciona un treballador/a</label>
                        <input
                            type="text"
                            list="workers"
                            id="worker_id_input"
                            name="worker_id_name"
                            class="w-full border border-gray-300 rounded p-2"
                            value="{{ $reservation->worker->first_name . ' ' . $reservation->worker->last_name ?? '' }}"
                            placeholder="Cerca un treballador..."
                            autocomplete="off"
                        />
                        <datalist id="workers">
                            @foreach ($workers as $worker)
                                <option data-id="{{ $worker->id }}" value="{{ $worker->first_name . ' ' . $worker->last_name }}"></option>
                            @endforeach
                        </datalist>

                        <!-- Input hidden per enviar l'ID real del client -->
                        <input type="hidden" id="worker_id" name="worker_id" value="{{ $reservation->worker_id }}">
                    </div>

                    <div class="mb-4">
                        <label for="reservation_date" class="block text-gray-700">Data de la reserva</label>
                        <input type="datetime-local" id="reservation_date" name="reservation_date" value="{{ date('Y-m-d\TH:i', strtotime($reservation->reservation_date)) }}" class="w-full border border-gray-300 rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label for="estimated_duration" class="block text-gray-700">Duració estimada (hores decimals)</label>
                        <input disabled type="text" id="estimated_duration" name="estimated_duration" value="{{ $reservation->estimated_duration }}" class="w-full border border-gray-300 rounded p-2 bg-gray-100">
                    </div>

                    <h1 class="text-2xl font-bold mb-6">Serveis</h1>
                    <div class="mb-4">
                        <table class="w-full border-collapse">
                            <thead>
                            <tr>
                                <th class="border px-4 py-2">Selecciona</th>
                                <th class="border px-4 py-2">Servei</th>
                                <th class="border px-4 py-2">Quantitat</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($allServices as $service)
                                <tr>
                                    <td class="border px-4 py-2">
                                        <input
                                            type="checkbox"
                                            name="services[{{ $service->id }}][id]"
                                            value="{{ $service->id }}"
                                            {{ $services->pluck('service_id')->contains($service->id) ? 'checked' : '' }}
                                        >
                                    </td>
                                    <td class="border px-4 py-2">{{ $service->name }}</td>
                                    <td class="border px-4 py-2">
                                        <input
                                            type="number"
                                            name="services[{{ $service->id }}][quantity]"
                                            class="w-full border border-gray-300 rounded p-2"
                                            value="{{ $services->firstWhere('service_id', $service->id)->quantity ?? 1 }}"
                                            min="1"
                                            {{ $services->pluck('service_id')->contains($service->id) ? '' : 'disabled' }}
                                        >
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-4">
                        <label for="notes">Nota de la reserva:</label>
                        <textarea id="notes" name="notes">{{$reservation->notes}}</textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualitzar</button>
                    </div>
                </form>
                <!-- Formulari per eliminar -->
                @if(auth()->user()->role->name === 'admin')
                    <div class="flex items-center justify-between">
                        <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="mt-4">
                            @csrf
                            @method('DELETE')

                            <!-- Botó per eliminar -->
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Eliminar</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const inputC = document.getElementById('client_id_input');
                const hiddenInputC = document.getElementById('client_id');
                const datalistC = document.getElementById('clients');
                const inputW = document.getElementById('worker_id_input');
                const hiddenInputW = document.getElementById('worker_id');
                const datalistW = document.getElementById('workers');

                inputC.addEventListener('input', function () {
                    // Busca l'opció seleccionada al datalist
                    const selectedOption = Array.from(datalistC.options).find(option => option.value === inputC.value);

                    if (selectedOption) {
                        // Si hi ha coincidència, assigna l'ID al camp hidden
                        hiddenInputC.value = selectedOption.getAttribute('data-id');
                    } else {
                        // Si no hi ha coincidència, buida el camp hidden
                        hiddenInputC.value = '';
                    }
                });

                inputW.addEventListener('input', function() {
                    const selectedOption = Array.from(datalistW.options).find(option => option.value === inputW.value);

                    if (selectedOption) {
                        hiddenInputW.value = selectedOption.getAttribute('data-id');
                    } else {
                        hiddenInputW.value = '';
                    }
                })
            });
        </script>
    </x-app-layout>

