<?php

namespace App\Http\Controllers;

use App\Models\Secretaire;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecretaireController extends Controller
{
    /**
     * Valider un rendez-vous spécifique
     * L'ID ici est celui du RENDEZ-VOUS
     */
    public function validerRendezVous(Request $request, $id)
    {
        
        // On récupère la secrétaire actuellement connectée
        $secretaire = Auth::user()->secretaire;

        if (!$secretaire) {
            return response()->json(['message' => 'Action non autorisée'], 403);
        }

        // On appelle ta méthode du modèle qui change le statut ET envoie l'email
        $success = $secretaire->validerRendezVous($id);

        if ($success) {
            return response()->json(['message' => 'Rendez-vous validé avec succès']);
        }

        return response()->json(['message' => 'Rendez-vous introuvable'], 404);
    }

    /**
     * Création complète : Compte + Profil Patient + Dossier
     */
    public function ajouterNouveauPatient(Request $request)
    {
        $validated = $request->validate([
            'cni' => 'required|string|unique:users,cni',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'required',
            'date_naissance' => 'required|date',
            'adresse' => 'required|string',
            'sexe' => 'required|string'
        ]);

        $secretaire = Auth::user()->secretaire;

        // Utilisation de ta méthode "atomique" du modèle
        $secretaire->creerFicheEtDossier($validated['cni'], $validated);

        return response()->json(['message' => 'Succès ! Le compte patient et son dossier médical sont créés.']);
    }
}