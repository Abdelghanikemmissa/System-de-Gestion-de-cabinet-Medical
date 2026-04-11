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
            'nom' => 'Alami',
            'prenom' => 'Ahmed',
            'email' => 'medecin@test.com',
            'password' => Hash::make('password'),
            'cni' => 'MED123',
            'role' => 'medecin',
        ]);
        
        Medecin::create([
            'user_id' => $userMedecin->id, 
            'specialite' => 'Cardiologue'
        ]);

        // 2. CRÉATION DE LA SECRÉTAIRE
        $userSecretaire = User::create([
            'nom' => 'Bennani',
            'prenom' => 'Sanaa',
            'email' => 'secretaire@test.com',
            'password' => Hash::make('password'),
            'cni' => 'SEC456',
            'role' => 'secretaire',
        ]);
        
        Secretaire::create([
            'user_id' => $userSecretaire->id
        ]);

        // 3. CRÉATION DE 6 PATIENTS AVEC DONNÉES COMPLÈTES
        $patientsData = [
            ['nom' => 'Idrissi', 'prenom' => 'Yassine', 'email' => 'yassine@test.com', 'cni' => 'BJ100', 'sexe' => 'M', 'tel' => '0611223344'],
            ['nom' => 'Mansouri', 'prenom' => 'Fatima', 'email' => 'fatima@test.com', 'cni' => 'AA200', 'sexe' => 'F', 'tel' => '0655667788'],
            ['nom' => 'Tazi', 'prenom' => 'Omar', 'email' => 'omar@test.com', 'cni' => 'CC300', 'sexe' => 'M', 'tel' => '0644332211'],
            ['nom' => 'Zahra', 'prenom' => 'Layla', 'email' => 'layla@test.com', 'cni' => 'DD400', 'sexe' => 'F', 'tel' => '0788990011'],
            ['nom' => 'Amrani', 'prenom' => 'Mehdi', 'email' => 'mehdi@test.com', 'cni' => 'EE500', 'sexe' => 'M', 'tel' => '0612345678'],
            ['nom' => 'Kabbaj', 'prenom' => 'Sofia', 'email' => 'sofia@test.com', 'cni' => 'FF600', 'sexe' => 'F', 'tel' => '0677889900'],
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
                'telephone' => $data['tel'],
                'date_naissance' => '1990-01-01', // Date par défaut pour éviter l'erreur NOT NULL
                'adresse' => 'Quartier Gauthier, Casablanca',
                'sexe' => $data['sexe']
            ]);
        }
    }
}