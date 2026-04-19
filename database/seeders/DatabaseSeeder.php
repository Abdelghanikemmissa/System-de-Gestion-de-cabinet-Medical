<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Medecin;
use App\Models\Secretaire;
use App\Models\Patient;
use App\Models\DossierMedical;
use App\Models\RendezVous;
use App\Models\Consultation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. MÉDECIN
        $userMedecin = User::create([
            'nom' => 'Alami', 'prenom' => 'Ahmed', 'email' => 'medecin@test.com',
            'password' => Hash::make('password'), 'cni' => 'MED123', 'role' => 'medecin',
        ]);
        $medecin = Medecin::create(['user_id' => $userMedecin->id, 'specialite' => 'Cardiologue']);

        // 2. SECRÉTAIRE
        $userSecretaire = User::create([
            'nom' => 'Bennani', 'prenom' => 'Sanaa', 'email' => 'secretaire@test.com',
            'password' => Hash::make('password'), 'cni' => 'SEC456', 'role' => 'secretaire',
        ]);
        Secretaire::create(['user_id' => $userSecretaire->id]);

        // 3. PATIENTS, DOSSIERS, RDV ET CONSULTATIONS
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
                'nom' => $data['nom'], 'prenom' => $data['prenom'], 'email' => $data['email'],
                'password' => Hash::make('password'), 'cni' => $data['cni'], 'role' => 'patient',
            ]);

            $patient = Patient::create([
                'user_id' => $userPatient->id,
                'telephone' => $data['tel'],
                'date_naissance' => '1990-01-01',
                'adresse' => 'Quartier Gauthier, Casablanca',
                'sexe' => $data['sexe']
            ]);

            // Dossier médical
            DossierMedical::create(['patient_id' => $patient->id, 'historique' => 'Dossier initial.']);

            // Rendez-vous (Aléatoire)
            $rdv = RendezVous::create([
                'patient_id' => $patient->id,
                'medecin_id' => $medecin->id,
                'date_heure' => now()->addDays(rand(0, 3))->setHour(rand(9, 17)),
                'statut' => 'en attent',
            ]);

            // Consultation (Historique)
            Consultation::create([
                'rendezvous_id' => $rdv->id,
                'compte_rendu' => 'Examen de contrôle standard.',
                'date_consultation' => now()->subDays(10),
            ]);
        }
    }
}