<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAddress>
 */
class UserAddressFactory extends Factory
{

    protected static array $usedUserIds = [];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Recuparem els usuaris amb els rols 1 o 2
        $users = User::whereIn('role_id', [1, 2])->pluck('id')->toArray();

        // Filtrem els id utilitzats
        $availableUserIds = array_diff($users, self::$usedUserIds);

        if (empty($availableUserIds)) {
            throw new \Exception('No more unique user Ids available.');
        }

        $userId = Arr::random($availableUserIds);

        self::$usedUserIds[] = $userId;
        return [
            'user_id' => $userId,
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'zip' => $this->faker->numerify('#####'),
        ];
    }
}
