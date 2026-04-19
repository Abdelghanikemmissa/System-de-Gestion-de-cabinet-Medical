<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\DossierMedical;
use Illuminate\Database\Seeder;

class DossierMedicalSeeder extends Seeder
{
    public function run(): void
    {
        // On récupère tous les patients existants
        $patients = Patient::all();

        foreach ($patients as $patient) {
            // Création d'un dossier médical pour chaque patient
            // On ne remplit que les champs définis dans ta migration
            DossierMedical::create([
                'patient_id' => $patient->id,
                'historique' => 'Dossier créé automatiquement le ' . now()->format('d/m/Y'),
            ]);
        }
    }
}