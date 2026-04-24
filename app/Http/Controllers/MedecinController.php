<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\RendezVous;
use App\Models\User;
use App\Models\Disponibilite;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MedecinController extends Controller
{
    // --- DASHBOARD ---
    public function index()
    {
        $aujourdhui = now()->toDateString();
        // On récupère le médecin connecté
        $medecin = auth()->user()->medecin;
        
        if (!$medecin) {
            return redirect('/')->with('error', 'Profil médecin non configuré.');
        }

        $nbPatients = Patient::count();
        $rdvAujourdhui = RendezVous::where('medecin_id', $medecin->id)
                                   ->whereDate('date_heure', $aujourdhui)
                                   ->count();

        $rendezVous = RendezVous::with('patient.user')
            ->where('medecin_id', $medecin->id)
            ->whereDate('date_heure', $aujourdhui)
            ->orderBy('date_heure', 'asc')
            ->get();

        return view('dashboard.medecin.index', compact('nbPatients', 'rdvAujourdhui', 'rendezVous'));
    }

    // --- GESTION PATIENTS ---
    public function listPatients()
    {
        $patients = Patient::with(['user', 'consultations'])->paginate(10);
        return view('dashboard.medecin.patients.index', compact('patients'));
    }

    public function rechercheCni(Request $request)
    {
        $request->validate(['cni' => 'required']);
        
        $user = User::where('cni', $request->cni)->with('patient')->first();
        
        if (!$user || !$user->patient) {
            return back()->with('error', 'Patient non trouvé avec cette CNI.');
        }

        return redirect()->route('medecin.dossier', $user->patient->id);
    }

    // --- DOSSIER MÉDICAL ---
    public function voirDossier($patient_id)
    {
        $patient = Patient::with(['user', 'dossierMedical.consultations.ordonnance'])
                          ->findOrFail($patient_id);

        return view('dashboard.medecin.dossier', compact('patient'));
    }

    
    // --- PLANNING ---


    public function voirPlanning()
    {
        // On ajoute ->where('statut', 'confirmer') pour filtrer les résultats
        $rendezVous = \App\Models\RendezVous::with(['patient.user'])
            ->where('statut', 'confirmé') 
            ->get();

        $events = $rendezVous->map(function ($rdv) {
            return [
                'title' => $rdv->patient->user->nom . ' ' . $rdv->patient->user->prenom,
                'start' => $rdv->date_heure,
                'url'   => route('medecin.dossier', $rdv->patient->id),
                'backgroundColor' => '#2563eb',
            ];
        });

        return view('dashboard.medecin.planning', compact('events'));
    }

    public function storeDispo(Request $request)
    {
        // 1. Validation stricte
        $request->validate([
            'date'  => 'required|date',
            'debut' => 'required',
            'fin'   => 'required|after:debut',
        ]);

        try {
            // 2. Création avec affichage d'erreur en cas d'échec
            \App\Models\Disponibilite::create([
                'medecin_id'  => auth()->user()->medecin->id,
                'jour'        => $request->date,
                'heure_debut' => $request->debut,
                'heure_fin'   => $request->fin,
                'est_libre'   => true, // Assure-toi que cette colonne existe !
            ]);

            return back()->with('success', 'Créneau ajouté avec succès !');
            
        } catch (\Illuminate\Database\QueryException $e) {
            // AFFICHE L'ERREUR SQL EXACTE
            dd($e->getMessage()); 
        }
    }
    public function indexDispo(Request $request)
    {
        $query = \App\Models\Disponibilite::where('medecin_id', auth()->user()->medecin->id);

        // Filtrage strict par format Y-m-d
        if ($request->has('filter_date') && !empty($request->filter_date)) {
            // La méthode whereDate traite automatiquement le format Y-m-d 
            // renvoyé par votre input type="date"
            $query->whereDate('jour', '=', $request->filter_date);
        }

        $disponibilites = $query->orderBy('jour', 'asc')->limit(5)->get();

        return view('dashboard.medecin.disponibilites', compact('disponibilites'));
    }

    public function destroy($id) {
        \App\Models\Disponibilite::findOrFail($id)->delete();
        return back()->with('success', 'Créneau supprimé.');
    }

    public function createConsultation($rendezvous_id)
{
    // 1. Chercher le rdv
    $rendezvous = \App\Models\RendezVous::findOrFail($rendezvous_id);
    
    // 2. Chercher le patient associé
    $patient = $rendezvous->patient; 

    // 3. Envoyer les deux à la VUE
    return view('dashboard.medecin.consultations.create', compact('rendezvous', 'patient'));
}
}