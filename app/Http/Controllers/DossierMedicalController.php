<?php

namespace App\Http\Controllers;

use App\Models\DossierMedical;
use Illuminate\Http\Request;
use App\Models\User;

class DossierMedicalController extends Controller
{
    public function consulterParCni($cni)
    {
        // 1. Trouver l'utilisateur et son profil patient
        $user = User::where('cni', $cni)->with('patient')->first();

        if (!$user || !$user->patient) {
            return response()->json(['message' => 'Patient introuvable'], 404);
        }

        // 2. Récupérer le dossier avec ses relations imbriquées
        $dossier = DossierMedical::with(['consultations.ordonnance'])
                    ->where('patient_id', $user->patient->id)
                    ->first();

        if (!$dossier) {
            return response()->json(['message' => 'Ce patient n\'a pas encore de dossier médical.'], 404);
        }

        // 3. Construction de l'historique propre pour le Frontend
        $historiqueComplet = $dossier->consultations->map(function ($consultation) {
            return [
                'date'         => $consultation->date_consultation->format('d/m/Y H:i'),
                'compte_rendu' => $consultation->compte_rendu,
                // On utilise created_at de l'ordonnance comme date d'émission
                'ordonnance'   => $consultation->ordonnance ? [
                    'contenu'       => $consultation->ordonnance->contenu,
                    'date_emission' => $consultation->ordonnance->created_at->format('d/m/Y')
                ] : null
            ];
        });

        return response()->json([
            'patient'    => $user->nom . ' ' . $user->prenom,
            'cni'        => $user->cni,
            'historique' => $historiqueComplet
        ], 200);
    }
}