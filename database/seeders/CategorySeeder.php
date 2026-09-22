<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Automobile',
                'description' => 'Voitures, véhicules premium et automobiles de prestige.',
            ],
            [
                'name' => 'Immobilier',
                'description' => 'Villas, appartements, terrains et biens immobiliers haut de gamme.',
            ],
            [
                'name' => 'Montres',
                'description' => 'Montres de luxe et pièces horlogères.',
            ],
            [
                'name' => 'Bijoux',
                'description' => 'Bijoux, diamants et pièces de joaillerie.',
            ],
            [
                'name' => 'Mode',
                'description' => 'Mode premium, vêtements, chaussures et accessoires.',
            ],
            [
                'name' => 'Voyage',
                'description' => 'Voyages, destinations et expériences exclusives.',
            ],
            [
                'name' => 'Hôtellerie',
                'description' => 'Hôtels, villas, résidences et séjours premium.',
            ],
            [
                'name' => 'Services privés',
                'description' => 'Conciergerie, chauffeur privé et services personnalisés.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'status' => true,
                ]
            );
        }
    }
}