<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function genererOrdonnance(Request $request, $id)
    {
        // 1. On cherche la consultation avec sa relation ordonnance
        $consultation = Consultation::with('ordonnance')->find($id);

        // 2. Vérification d'existence
        if (!$consultation) {
            return response()->json([
                'error' => "La consultation #$id n'existe pas."
            ], 404);
        }

        // 3. SÉCURITÉ : Vérifier si une ordonnance existe déjà
        if ($consultation->ordonnance) {
            return response()->json([
                'message' => 'Une ordonnance existe déjà pour cette consultation.',
                'ordonnance' => $consultation->ordonnance
            ], 200); // On renvoie l'existante au lieu d'en créer une nouvelle
        }

        // 4. On appelle l'opération du modèle
        $contenu = $request->input('contenu', 'Ordonnance standard');
        $ordonnance = $consultation->genererOrdonnance($contenu);

        return response()->json([
            'message' => 'Ordonnance générée avec succès',
            'data' => $ordonnance
        ], 201);
    }
}