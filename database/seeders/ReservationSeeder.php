<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reservations = [
            [
                'client_id' => null,
                'client_name' => 'John Doe',
                'client_phone' => '123456789',
                'worker_id' => User::whereIn('role_id', [2, 3])->inRandomOrder()->value('id'),
                'reservation_date' => Carbon::now()->addDays(2)->setTime(10, 0),
                'estimated_duration' => null,
                'status' => 'pending',
                'notes' => 'Client prefers morning appointments.',
                'work_area' => 1,
            ],
            [
                'client_id' => 1,
                'client_name' => null,
                'client_phone' => null,
                'worker_id' => User::whereIn('role_id', [2, 3])->inRandomOrder()->value('id'),
                'reservation_date' => Carbon::now()->addDays(4)->setTime(14, 30),
                'estimated_duration' => null,
                'status' => 'pending',
                'notes' => 'Regular client. Request for the same worker as last time.',
                'work_area' => 2,
            ],
            [
                'client_id' => null,
                'client_name' => 'Jane Smith',
                'client_phone' => '987654321',
                'worker_id' => User::whereIn('role_id', [2, 3])->inRandomOrder()->value('id'),
                'reservation_date' => Carbon::now()->addDays(6)->setTime(16, 0),
                'estimated_duration' => null,
                'status' => 'pending',
                'notes' => 'Requested full hair color.',
                'work_area' => 1,
            ],
            [
                'client_id' => 2,
                'client_name' => null,
                'client_phone' => null,
                'worker_id' => User::whereIn('role_id', [2, 3])->inRandomOrder()->value('id'),
                'reservation_date' => Carbon::now()->addDays(7)->setTime(9, 0),
                'estimated_duration' => null,
                'status' => 'pending',
                'notes' => 'Cancelled by client due to a schedule conflict.',
                'work_area' => 4,
            ],
            [
                'client_id' => null,
                'client_name' => 'Emily Johnson',
                'client_phone' => '567890123',
                'worker_id' => User::whereIn('role_id', [2, 3])->inRandomOrder()->value('id'),
                'reservation_date' => Carbon::now()->addDays(10)->setTime(11, 30),
                'estimated_duration' => null,
                'status' => 'pending',
                'notes' => 'Client requested consultation for hair treatment.',
                'work_area' => 3,
            ],
            [
                'client_id' => 3,
                'client_name' => null,
                'client_phone' => null,
                'worker_id' => User::whereIn('role_id', [2, 3])->inRandomOrder()->value('id'),
                'reservation_date' => Carbon::now()->addDays(12)->setTime(13, 45),
                'estimated_duration' => null,
                'status' => 'pending',
                'notes' => 'Special request for highlights and treatment.',
                'work_area' => 5,
            ],
            [
                'client_id' => null,
                'client_name' => 'Michael Brown',
                'client_phone' => '678901234',
                'worker_id' => User::whereIn('role_id', [2, 3])->inRandomOrder()->value('id'),
                'reservation_date' => Carbon::now()->addDays(14)->setTime(15, 15),
                'estimated_duration' => null,
                'status' => 'pending',
                'notes' => 'Previous client, satisfied with the service.',
                'work_area' => 6,
            ],
            [
                'client_id' => 4,
                'client_name' => null,
                'client_phone' => null,
                'worker_id' => User::whereIn('role_id', [2, 3])->inRandomOrder()->value('id'),
                'reservation_date' => Carbon::now()->addDays(15)->setTime(10, 45),
                'estimated_duration' => null,
                'status' => 'pending',
                'notes' => 'Client requested stylist with experience in bridal hairstyles.',
                'work_area' => 5,
            ],
            [
                'client_id' => null,
                'client_name' => 'Sarah Williams',
                'client_phone' => '345678901',
                'worker_id' => User::whereIn('role_id', [2, 3])->inRandomOrder()->value('id'),
                'reservation_date' => Carbon::now()->addDays(20)->setTime(12, 0),
                'estimated_duration' => null,
                'status' => 'pending',
                'notes' => 'Hair smoothing treatment requested.',
                'work_area' => 3,
            ],
            [
                'client_id' => 5,
                'client_name' => null,
                'client_phone' => null,
                'worker_id' => User::whereIn('role_id', [2, 3])->inRandomOrder()->value('id'),
                'reservation_date' => Carbon::now()->addDays(25)->setTime(17, 30),
                'estimated_duration' => null,
                'status' => 'pending',
                'notes' => 'Appointment scheduled for styling for a wedding.',
                'work_area' => 6,
            ],
        ];

        foreach ($reservations as $reservation) {
            Reservation::updateOrCreate(
                ['reservation_date' => $reservation['reservation_date'], 'worker_id' => $reservation['worker_id']],
                $reservation
            );
        }
    }
}
