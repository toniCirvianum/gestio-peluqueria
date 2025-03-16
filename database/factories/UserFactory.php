<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'role_id' => Role::where('name', 'client')->first()->id, // Per defecte serà client
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->numerify('#########'),

        ];
    }

    /**
     * Indica que l'usuari ha de tenir el rol d'admin.
     *
     * @return Factory
     */
    public function admin(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => Role::where('name', 'admin')->first()->id,
                'username' => $this->faker->unique()->userName,
                'password' => bcrypt('password'), // Contrassenya predeterminada
                'verified' => $this->faker->boolean(80), // 80% probabilitat que sigui verificat
            ];
        });
    }

    /**
     * Indica que l'usuari ha de tenir el rol de treballador (worker).
     *
     * @return Factory
     */
    public function worker(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => Role::where('name', 'worker')->first()->id,
                'username' => $this->faker->unique()->userName,
                'password' => bcrypt('password'), // Contrassenya predeterminada
                'verified' => $this->faker->boolean(80), // 80% probabilitat que sigui verificat
            ];
        });
    }

    /**
     * Indica que l'usuari ha de tenir el rol de client.
     *
     * @return Factory
     */
    public function client(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => Role::where('name', 'client')->first()->id,
            ];
        });
    }
}
