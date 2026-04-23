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

    public function indexRendezvous(Request $request)
{
    $query = \App\Models\RendezVous::query()->with(['patient.user', 'medecin.user']);

    // 1. Filtrage par date
    if ($request->filled('date')) {
        $query->whereDate('date_heure', $request->date);
    }

    // 2. Filtrage par statut
    if ($request->filled('statut')) {
        // On utilise la comparaison directe
        $query->where('statut', $request->statut);
    }

    $rendezvous = $query->latest()->get();

    return view('dashboard.secretaire.rendezvous', compact('rendezvous'));
}

public function voirPlanningAujourdhui()
{
    // Récupère uniquement les RDV confirmés pour la date actuelle
    $rdvAujourdhui = \App\Models\RendezVous::with(['patient.user'])
        ->where('statut', 'confirmé')
        ->whereDate('date_heure', today()) // Filtre sur la date d'aujourd'hui
        ->orderBy('date_heure', 'ASC')    // Trié par heure
        ->get();

    return $rdvAujourdhui;
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