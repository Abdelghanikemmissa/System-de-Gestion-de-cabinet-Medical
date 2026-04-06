<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Medecin;
use App\Models\Secretaire;
use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. CRÉATION DU MÉDECIN
        $userMedecin = User::create([
            'nom' => 'Principal',
            'prenom' => 'Docteur',
            'email' => 'medecin@test.com',
            'password' => Hash::make('password'),
            'cni' => 'MED123',
            'role' => 'medecin',
        ]);
        Medecin::create(['user_id' => $userMedecin->id, 'specialite' => 'Généraliste']);

        // 2. CRÉATION DE LA SECRÉTAIRE
        $userSecretaire = User::create([
            'nom' => 'Assistante',
            'prenom' => 'Julie',
            'email' => 'secretaire@test.com',
            'password' => Hash::make('password'),
            'cni' => 'SEC456',
            'role' => 'secretaire',
        ]);
        Secretaire::create(['user_id' => $userSecretaire->id]);

        // 3. CRÉATION DE 6 PATIENTS
        $patientsData = [
            ['nom' => 'Dupont', 'prenom' => 'Jean', 'email' => 'jean@test.com', 'cni' => 'BE200200'],
            ['nom' => 'Martin', 'prenom' => 'Alice', 'email' => 'alice@test.com', 'cni' => 'AA300300'],
            ['nom' => 'Lefebvre', 'prenom' => 'Thomas', 'email' => 'thomas@test.com', 'cni' => 'CC400400'],
            ['nom' => 'Moreau', 'prenom' => 'Sophie', 'email' => 'sophie@test.com', 'cni' => 'DD505505'],
            ['nom' => 'Petit', 'prenom' => 'Lucas', 'email' => 'lucas@test.com', 'cni' => 'EE606606'],
            ['nom' => 'Rousseau', 'prenom' => 'Emma', 'email' => 'emma@test.com', 'cni' => 'FF707707'],
        ];

        foreach ($patientsData as $data) {
            $userPatient = User::create([
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'cni' => $data['cni'],
                'role' => 'patient',
            ]);

            Patient::create([
                'user_id' => $userPatient->id,
                'telephone' => '0600000000'
            ]);
        }
    }
}