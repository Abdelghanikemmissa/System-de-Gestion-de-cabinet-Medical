<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RendezVousController extends Controller
{
    /**
     * Confirmer le RDV et renvoyer l'état mis à jour
     */
    public function confirmer(Request $request, $id)
    {
        if (Auth::user()->role !== 'secretaire') {
            return response()->json(['message' => 'Accès refusé : Réservé à la secrétaire'], 403);
        }
        $rdv = RendezVous::findOrFail($id);
        $rdv->confirmer();

        return response()->json([
            'message' => 'Rendez-vous confirmé',
            'data' => $rdv // Ton collègue aura le nouveau statut "confirmé" ici
        ]);
    }

    /**
     * Annuler le RDV
     */
    public function annuler(Request $request, $id)
    {
        if (Auth::user()->role !== 'secretaire') {
            return response()->json(['message' => 'Accès refusé : Réservé à la secrétaire'], 403);
        }
        $rdv = RendezVous::findOrFail($id);
        $rdv->annuler();

        return response()->json([
            'message' => 'Rendez-vous annulé',
            'data' => $rdv
        ]);
    }

    /**
     * Notification manuelle (Si besoin de renvoyer l'email)
     */
    public function envoyerNotification(Request $request, $id)
    {
        $rdv = RendezVous::findOrFail($id);
        
        // On s'assure que le RDV est bien chargé avec les infos du patient
        $rdv->load('patient.user');
        
        $rdv->envoyerNotificationEmail();

        return response()->json([
            'message' => 'Notification envoyée à ' . $rdv->patient->user->email
        ]);
    }

    
}