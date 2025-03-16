<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6 pt-10">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Crear Reserva</h1>

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

            <!-- Formulari per crear una reserva -->
            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf

                <!-- Client -->
                <div class="mb-4">
                    <label for="client_id" class="block text-gray-700">Selecciona un client</label>
                    <input
                        type="text"
                        list="clients"
                        id="client_id_input"
                        name="client_id_name"
                        class="w-full border border-gray-300 rounded p-2"
                        placeholder="Cerca un client registrat..."
                        autocomplete="off"
                    />
                    <datalist id="clients">
                        @foreach ($clients as $client)
                            <option data-id="{{ $client->id }}" value="{{ $client->first_name . ' ' . $client->last_name }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" id="client_id" name="client_id" value="">
                </div>

                <!-- Client no registrat -->
                <div class="mb-4">
                    <label for="client_name" class="block text-gray-700">Nom del Client</label>
                    <input type="text" name="client_name" id="client_name" class="w-full border border-gray-300 rounded p-2" placeholder="Nom del client no registrat...">
                </div>

                <div class="mb-4">
                    <label for="client_phone" class="block text-gray-700">Telèfon del client</label>
                    <input type="text" name="client_phone" id="client_phone" class="w-full border border-gray-300 rounded p-2" placeholder="Telefon client no registrat...">
                </div>

                <!-- Treballador -->
                <div class="mb-4">
                    <label for="worker_id" class="block text-gray-700">Selecciona un treballador/a</label>
                    <input
                        type="text"
                        list="workers"
                        id="worker_id_input"
                        name="worker_id_name"
                        class="w-full border border-gray-300 rounded p-2"
                        placeholder="Cerca un treballador..."
                        autocomplete="off"
                    />
                    <datalist id="workers">
                        @foreach ($workers as $worker)
                            <option data-id="{{ $worker->id }}" value="{{ $worker->first_name . ' ' . $worker->last_name }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" id="worker_id" name="worker_id" value="">
                </div>

                <!-- Data i hora de la reserva -->
                <div class="mb-4">
                    <label for="reservation_date" class="block text-gray-700">Data de la reserva</label>
                    <input type="datetime-local" id="reservation_date" name="reservation_date" class="w-full border border-gray-300 rounded p-2">
                </div>

                <div class="mb-4">
                    <label for="work_area" class="block text-gray-700">Lloc de treball</label>
                    <input type="number" name="work_area" id="work_area" max="10" class="w-full border border-gray-300 rounded p-2" placeholder="Número de la zona on es treballarà...">
                </div>

                <!-- Serveis -->
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
                                    <input type="checkbox" name="services[{{ $service->id }}][id]" value="{{ $service->id }}">
                                </td>
                                <td class="border px-4 py-2">{{ $service->name }}</td>
                                <td class="border px-4 py-2">
                                    <input
                                        type="number"
                                        name="services[{{ $service->id }}][quantity]"
                                        class="w-full border border-gray-300 rounded p-2"
                                        value="1"
                                        min="1"
                                        disabled
                                    >
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Notes -->
                <div class="mb-4">
                    <label for="notes" class="block text-gray-700">Nota de la reserva</label>
                    <textarea id="notes" name="notes" class="w-full border border-gray-300 rounded p-2" placeholder="Escriu les notes..."></textarea>
                </div>

                <!-- Botó de crear -->
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Crear Reserva</button>
                </div>
            </form>
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
                const selectedOption = Array.from(datalistC.options).find(option => option.value === inputC.value);
                hiddenInputC.value = selectedOption ? selectedOption.getAttribute('data-id') : '';
            });

            inputW.addEventListener('input', function () {
                const selectedOption = Array.from(datalistW.options).find(option => option.value === inputW.value);
                hiddenInputW.value = selectedOption ? selectedOption.getAttribute('data-id') : '';
            });

            document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const quantityInput = this.closest('tr').querySelector('input[type="number"]');
                    quantityInput.disabled = !this.checked;
                    if (!this.checked) quantityInput.value = 1;
                });
            });
        });
    </script>
</x-app-layout>
