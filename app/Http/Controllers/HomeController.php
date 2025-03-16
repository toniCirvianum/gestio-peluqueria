<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EnsureUserHasRole;
use App\Models\Reservation;
use DateTime;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     * @throws \DateMalformedStringException
     */
    public function __invoke(Request $request)
    {
        $events = [];

        $query = Reservation::with(['client', 'worker']);

        $user = auth()->user();

        $user->hasRole('worker') && $query->where('worker_id', auth()->user()->getAuthIdentifier());

        $reservations = $query->get();

        foreach ($reservations as $reservation) {
            $decimalValue = floatval(str_replace(',', '.', $reservation->estimated_duration));
            $hours = floor($decimalValue);
            $minutes = round(($decimalValue - $hours) * 60);
            $date = new DateTime($reservation->reservation_date);
            $date->modify('+' . $hours . ' hours');
            $date->modify('+' . $minutes . ' minutes');

            $events[] = [
                'id' => $reservation->id,
                'title' => $reservation->client != null ? $reservation->client->first_name . ' ' . $reservation->client->last_name . ' (' . $reservation->worker->first_name. ' ' . $reservation->worker->last_name . ')' : $reservation->client_name . ' (' . $reservation->worker->first_name. ' ' . $reservation->worker->last_name . ')',
                'start' => $reservation->reservation_date,
                'end' => $date->format('Y-m-d H:i:s'),
            ];
        }

        return view('home', compact('events'));
    }
}
