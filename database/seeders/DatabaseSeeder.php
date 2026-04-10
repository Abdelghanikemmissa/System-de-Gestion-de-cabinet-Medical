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
            'date_naissance' => '1990-01-01',
            'email' => 'secretaire@test.com',
            'password' => Hash::make('password'),
            'cni' => 'SEC456',
            'role' => 'secretaire',
        ]);
        Secretaire::create(['user_id' => $userSecretaire->id]);

        // 3. CRÉATION DE 6 PATIENTS
        $patientsData = [
            ['nom' => 'Dupont', 'prenom' => 'Jean', 'date_naissance' => '1985-05-15', 'email' => 'jean@test.com', 'cni' => 'BE200200'],
            ['nom' => 'Martin', 'prenom' => 'Alice', 'date_naissance' => '1992-08-20', 'email' => 'alice@test.com', 'cni' => 'AA300300'],
            ['nom' => 'Lefebvre', 'prenom' => 'Thomas', 'date_naissance' => '1988-12-10', 'email' => 'thomas@test.com', 'cni' => 'CC400400'],
            ['nom' => 'Moreau', 'prenom' => 'Sophie', 'date_naissance' => '1995-03-25', 'email' => 'sophie@test.com', 'cni' => 'DD505505'],
            ['nom' => 'Petit', 'prenom' => 'Lucas', 'date_naissance' => '1990-11-30', 'email' => 'lucas@test.com', 'cni' => 'EE606606'],
            ['nom' => 'Rousseau', 'prenom' => 'Emma', 'date_naissance' => '1993-07-18', 'email' => 'rousseau@gmail.com']
        ];

        foreach ($patientsData as $data) {
            $userPatient = User::create([
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'cni' => $data['cni'],
                'date_naissance' => $data['date_naissance'],
                'role' => 'patient',
            ]);

            Patient::create([
                'user_id' => $userPatient->id,
                'telephone' => '0600000000'
            ]);
        }
    }
}