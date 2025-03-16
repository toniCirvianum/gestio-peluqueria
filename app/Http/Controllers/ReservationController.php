<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // Obtenir la reserva
        $allServices = Service::all();
        $clients = User::all();
        $workers = User::where('role_id', '2')->get();
        // Carregar la vista d'edició i passar la reserva
        return view('reservations.create', compact('clients', 'allServices',  'workers'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {


            // Validació de les dades
            $request->validate([
                'client_id' => 'nullable|exists:users,id',
                'client_name' => 'nullable|string',
                'client_phone' => 'nullable|string',
                'worker_id' => 'required|exists:users,id',
                'reservation_date' => 'required|date',
                'work_area' => 'required|integer',
                'services' => 'nullable|array',
                'services.*.id' => 'exists:services,id',
                'services.*.quantity' => 'nullable|integer|min:1',
                'notes' => 'nullable|string|max:1000',
            ]);

            // Crear la reserva
            $reservation = Reservation::create([
                'client_id' => $request->client_id ?? null,
                'client_name' => $request->client_name ?? null,
                'client_phone' => $request->client_phone ?? null,
                'worker_id' => $request->worker_id,
                'reservation_date' => $request->reservation_date,
                'work_area' => $request->work_area ?? 1,
                'notes' => $request->notes ?? null,
            ]);

            // Afegir serveis si existeixen
            if ($request->has('services')) {
                foreach ($request->services as $serviceData) {
                    if (isset($serviceData['id'])) {
                        $reservation->reservationServices()->create([
                            'service_id' => $serviceData['id'],
                            'quantity' => $serviceData['quantity'] ?? 1,
                        ]);
                    }
                }
            }

            return redirect()->route('home')->with('success', 'Reserva creada correctament.');
        } catch (\Exception $e) {

            // Retorna amb el missatge d'error
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error en crear la reserva: ' . $e->getMessage());
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Mostra la pàgina per editar la reserva.
     *
     * @param int $id
     *
     */
    public function edit($id)
    {
        try {
            // Obtenir la reserva
            $reservation = Reservation::with('reservationServices.service')->findOrFail($id);
            $allServices = Service::all();
            $services = $reservation->reservationServices ?? collect([]);
            $clients = User::all();
            $workers = User::where('role_id', '2')->get();

            // Carregar la vista d'edició i passar la reserva
            return view('reservations.edit', compact('reservation', 'clients', 'allServices', 'services', 'workers'));
        } catch (\Exception $e) {
            // Retornar a la pàgina principal amb un missatge d'error
            return redirect()->route('home')->with('error', 'No s\'ha trobat la reserva.');
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function updateCalendar(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|integer|exists:reservations,id',
            'start' => 'required|string',
        ]);

        try {

            $reservation = Reservation::findOrFail($request->id);

            $start = new \DateTime($request->start);

            $reservation->reservation_date = $start->format('Y-m-d H:i:s');

            $reservation->save();

            return response()->json([
                'success' => true,
                'message' => 'Reserva actualitzada correctament.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Actualitza la reserva des de la vista d'edició (HTML Form).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'services' => 'nullable|array', // Permet que 'services' sigui nul
            'services.*.id' => 'exists:services,id', // Comprova que els serveis existeixen
            'services.*.quantity' => 'nullable|integer|min:1', // Quantitats mínimes
            'reservation_date' => 'required|date_format:Y-m-d\TH:i', // Data vàlida
            'client_id' => 'nullable|exists:users,id', // Comprova si el client existeix
            'worker_id' => 'nullable|exists:users,id', // Comprova si el treballador existeix
            'notes' => 'nullable|string|max:1000', // Comprova la longitud de les notes
        ]);

        try {
            $reservation = Reservation::findOrFail($id);

            // Actualitza la informació de la reserva
            $reservation->reservation_date = $request->reservation_date;
            $reservation->client_id = $request->client_id ?? null;
            $reservation->client_name = $request->client_name ?? null;
            $reservation->client_phone = $request->client_phone ?? null;
            $reservation->worker_id = $request->worker_id;
            $reservation->notes = $request->notes;
            $reservation->save();
            // Elimina els serveis associats
            $reservation->reservationServices()->delete();

            // Assigna els serveis seleccionats amb quantitats
            if ($request->has('services') && is_array($request->services)) {
                foreach ($request->services as $serviceData) {
                    if (isset($serviceData['id'])) { // Comprova que la clau 'id' existeix
                        $reservation->reservationServices()->create([
                            'service_id' => $serviceData['id'],
                            'quantity' => $serviceData['quantity'] ?? 1,
                        ]);
                    }
                }
            }

            return redirect()->route('reservations.edit', $reservation->id)
                ->with('success', 'Reserva actualitzada correctament.');
        } catch (\Exception $e) {
            return redirect()->route('reservations.edit', $id)
                ->with('error', 'Hi ha hagut un error en actualitzar la reserva.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Obtenir la reserva
            $reservation = Reservation::findOrFail($id);
            // Eliminar la reserva
            $reservation->delete();

            // Redirigir a la pàgina d'inici amb un missatge de confirmació
            return redirect()->route('home')->with('success', 'Reserva eliminada correctament.');
        } catch (\Exception $e) {
            // En cas d'error, redirigir amb un missatge d'error
            return redirect()->route('home')->with('error', 'No s\'ha pogut eliminar la reserva.');
        }
    }
}
