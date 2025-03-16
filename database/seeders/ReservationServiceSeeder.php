<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\ReservationService;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ReservationServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtenir totes les reserves existents
        $reservations = Reservation::all();

        // Obtenir tots els serveis existents
        $services = Service::all();

        // Afegir serveis a les reserves existents
        foreach ($reservations as $reservation) {
            // Selecciona serveis aleatoris per a la reserva (entre 1 i 3 serveis per reserva)
            $randomServices = $services->random(rand(1, 3));

            foreach ($randomServices as $service) {
                ReservationService::updateOrCreate(
                    [
                        'reservation_id' => $reservation->id,
                        'service_id' => $service->id,
                    ],
                    [
                        'quantity' => 1 // La quantitat per defecte sempre és 1
                    ]
                );
            }
        }
    }
}
