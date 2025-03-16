<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear 1 Admin
        User::factory()->admin()->create([
            'first_name' => 'Usuari',
            'last_name' => 'Eliminat',
            'email' => 'deleted@user.com',
            'phone' => '666555888',
            'username' => 'userdel',
            'password' => bcrypt('password'),
            'verified' => true,
        ]);

        User::factory()->admin()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'phone' => '666555888',
            'username' => 'admin',
            'password' => bcrypt('password'),
            'verified' => true,
        ]);


        // Crear 4 Treballadors
        User::factory()->worker()->count(4)->create();

        // Crear 10 Clients
        User::factory()->client()->count(10)->create();
    }
}

