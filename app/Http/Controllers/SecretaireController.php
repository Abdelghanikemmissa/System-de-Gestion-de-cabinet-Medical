<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecretaireController extends Controller
{
    public function showDashboard()
    {
        $stats = [
            'today_rv' => RendezVous::whereDate('date_heure', today())->count(),
            'new_patients' => Patient::whereDate('created_at', today())->count(),
            'pending' => RendezVous::where('statut', 'en attente')->count(),
        ];

        $rendezvous = RendezVous::with(['patient.user', 'medecin.user'])
            ->where('statut', 'en attente')
            ->orderBy('date_heure', 'asc')
            ->get();

        return view('/secretaire/dashboard', compact('stats', 'rendezvous'));
    }

    public function validerRendezVous(Request $request, $id)
    {
        $secretaire = Auth::user()->secretaire;

        if (!$secretaire) {
            return back()->with('error', 'Action non autorisée');
        }

        $success = $secretaire->validerRendezVous($id);

        return $success 
            ? back()->with('success', 'Rendez-vous validé !')
            : back()->with('error', 'Rendez-vous introuvable');
    }

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
        $secretaire->creerFicheEtDossier($validated['cni'], $validated);

        return redirect()->route('secretaire.dashboard')->with('success', 'Patient créé avec succès');
    }

    public function indexPatients()
    {
        // Fetches all patients with their user account information
        $patients = \App\Models\Patient::with('user')->get();
        
        return view('/secretaire/patient', compact('patients'));
    }


    public function indexRendezVous()
    {
        $rendezvous = RendezVous::with(['patient.user', 'medecin.user'])
            ->orderBy('date_heure', 'desc')
            ->get();

        return view('secretaire.rendezvous', compact('rendezvous'));
    }

    public function annulerRendezVous(Request $request, $id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->update(['statut' => 'annulé']);

        return back()->with('success', 'Rendez-vous annulé avec succès.');
    }

    
}