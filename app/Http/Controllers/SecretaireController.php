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


    // Modifier/Ajouter ces méthodes dans SecretaireController

       public function indexRendezVous() {
    // This fetches all appointments so you can see 'en attente' ones at the top
        $rendezvous = RendezVous::with(['patient.user', 'medecin.user'])
            // ->orderByRaw("FIELD(statut, 'en attente') DESC") 
            ->orderBy('date_heure', 'asc')
            ->get();
        
    return view('secretaire.rendezvous', compact('rendezvous'));
}

    public function confirmerRendezVous($id) {
        $rdv = RendezVous::findOrFail($id);
        $rdv->update(['statut' => 'confirmé']);
        return back()->with('success', 'Le rendez-vous a été confirmé.');
    }

    public function validerRendezVous($id) {
    // 1. Find the specific appointment
    $rdv = RendezVous::findOrFail($id);

    // 2. Update the status directly
    $rdv->update([
        'statut' => 'confirmé'
    ]);

    // 3. Go back to the list
    return back()->with('success', 'Rendez-vous confirmé avec succès !');
}

    public function annulerRendezVous($id) {
        $rdv = RendezVous::findOrFail($id);
        $rdv->update(['statut' => 'annulé']);
        return back()->with('success', 'Le rendez-vous a été annulé.');
    }

    
}