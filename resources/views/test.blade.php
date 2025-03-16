<?php
    use App\Models\User;
    use App\Models\Service;
    use Illuminate\Support\Facades\DB;
    ?>
<!doctype html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <h1>Test Reserves</h1>
    <ul style="display: flex; flex-wrap: wrap">
    @foreach($reservations as $reservation)
        <li style="list-style: none; border: 1px solid black; border-radius: 15px; width: 20%; margin-bottom: 5px; padding: 10px">
            <p>Id: {{$reservation->id}}</p>
            @php
                $worker = User::where('id', $reservation->worker_id)->first();
                $services = DB::table('services')
                    ->join('reservation_services', 'reservation_services.service_id', '=', 'services.id')
                    ->where('reservation_services.reservation_id', $reservation->id)
                    ->get();
            @endphp
            @if($reservation->client_id !== null)
                @php
                $client = User::where('id', $reservation->client_id)->first();
                @endphp
                <p>Client: {{$client->first_name.' '.$client->last_name}}</p>
            @else
                <p>Client: {{$reservation->client_name}}</p>
           @endif

            <p>Worker: {{$worker->first_name.' '.$worker->last_name}}</p>
            <p>Services: {{$reservation->worker->first_name}}</p>
            <ul>
            @foreach($services as $service)
                <li>
                    {{$service->name}}
                </li>
            @endforeach
            </ul>
            <x-nav-link>
            Date: {{$reservation->reservation_date}}
            </x-nav-link>
        </li>
    @endforeach
    </ul>
</body>
</html>
