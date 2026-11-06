<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Demo',
            'email' => 'demo@taskflow.test',
        ]);

        $site = $user->projects()->create([
            'name' => 'Site vitrine',
            'description' => 'Refonte du site de l\'entreprise.',
        ]);

        Storage::disk('public')->put('attachments/cahier-des-charges.txt', "Pages : accueil, services, contact.\n");

        $site->tasks()->createMany([
            ['title' => 'Maquettes', 'status' => 'done', 'deadline' => today()->subDays(10)],
            ['title' => 'Cahier des charges', 'status' => 'done', 'attachment_path' => 'attachments/cahier-des-charges.txt'],
            ['title' => 'Intégration page d\'accueil', 'status' => 'in_progress', 'deadline' => today()->subDays(2)],
            ['title' => 'Formulaire de contact', 'status' => 'pending', 'deadline' => today()->addDays(5)],
        ]);

        $user->projects()->create(['name' => 'Application mobile', 'description' => 'Première version iOS et Android.'])
            ->tasks()->createMany([
                ['title' => 'Choix de la stack', 'status' => 'done'],
                ['title' => 'Écran de connexion', 'status' => 'in_progress', 'deadline' => today()->addDays(3)],
                ['title' => 'Notifications', 'status' => 'pending', 'deadline' => today()->subDay()],
            ]);

        $user->projects()->create(['name' => 'Déménagement bureau'])
            ->tasks()->createMany([
                ['title' => 'Réserver le camion', 'status' => 'pending', 'deadline' => today()->addDays(10)],
                ['title' => 'Cartons', 'status' => 'pending'],
            ]);
    }
}
