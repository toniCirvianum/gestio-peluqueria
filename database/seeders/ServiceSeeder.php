<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
                ["name" => "Men's Haircut", "description" => "Classic or modern haircut for men, including wash and styling.", "price" => 20.00, "duration" => 0.75],
                ["name" => "Women's Haircut", "description" => "Customized haircut for women, with options for wash and styling.", "price" => 30.00, "duration" => 1.00],
                ["name" => "Full Hair Color", "description" => "Complete hair coloring with quality products for a shiny finish.", "price" => 60.00, "duration" => 2.00],
                ["name" => "Highlights", "description" => "Application of highlights to add light and volume to the hair, including wash and styling.", "price" => 70.00, "duration" => 2.50],
                ["name" => "Special Occasion Styling", "description" => "Styling for special occasions, such as weddings or events, including pre-preparation.", "price" => 40.00, "duration" => 1.50],
                ["name" => "Hydration Treatment", "description" => "Intensive treatment to hydrate and revitalize the hair, including scalp massage.", "price" => 35.00, "duration" => 1.00],
                ["name" => "Children's Haircut", "description" => "Haircut for kids in a fun and friendly environment.", "price" => 15.00, "duration" => 0.50],
                ["name" => "Temporary Smoothing Treatment", "description" => "Temporary smoothing treatment to soften the hair, including wash and styling.", "price" => 80.00, "duration" => 2.00],
                ["name" => "Beard Coloring", "description" => "Coloring of the beard for a more groomed and styled appearance.", "price" => 25.00, "duration" => 0.50],
                ["name" => "Haircut and Styling", "description" => "Haircut with personalized styling, including wash.", "price" => 45.00, "duration" => 1.25]
            ];

        foreach ($services as $service) {
            Service::updateOrCreate(['name' => $service['name']], $service);
        }

    }
}
