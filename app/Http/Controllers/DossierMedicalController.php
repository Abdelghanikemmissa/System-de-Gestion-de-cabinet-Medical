<?php

namespace App\Http\Controllers;

use App\Models\DossierMedical;
use Illuminate\Http\Request;
use App\Models\User;

class DossierMedicalController extends Controller
{
    public function consulterParCni($cni)
{
    // 1. On récupère l'utilisateur avec son profil patient
    $user = \App\Models\User::where('cni', $cni)->with('patient')->first();

    // 2. Sécurité : Si l'utilisateur n'existe pas
    if (!$user) {
        return redirect()->back()->with('error', 'Utilisateur introuvable.');
    }

    // 3. Récupérer le dossier médical via l'ID du patient
    $dossier = \App\Models\DossierMedical::with(['consultations.ordonnance'])
                ->where('patient_id', $user->patient->id)
                ->first();

    // 4. On prépare les consultations (même si le dossier est vide)
    $consultations = $dossier ? $dossier->consultations->sortByDesc('date_consultation') : collect();

    // 5. ENVOI DES VARIABLES À LA VUE
    // compact('user') crée un tableau ['user' => $user]
    return view('dashboard.medecin.dossier_detail', compact('user', 'consultations'));
}
}