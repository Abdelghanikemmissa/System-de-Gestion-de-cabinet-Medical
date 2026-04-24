<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\RendezVous;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Consultation;

class PatientController extends Controller
{

    public function index(Request $request)
    {
        // 1. On commence la requête de base
        $query = Patient::with('user');

        // 2. On applique le filtre de recherche si une recherche est envoyée
        if ($request->filled('search')) {
            $query->rechercher($request->search); // Utilise ton "Scope" créé dans le modèle
        }

        // 3. On pagine les résultats
        $patients = $query->paginate(10);

        // 4. On retourne la vue partagée
        return view('dashboard.medecin.patients.index', compact('patients'));
    }

    /**
     * Recherche un patient spécifique et affiche son dossier complet
     */
    public function showByCni($cni)
    {
        $user = User::where('cni', $cni)->with(['patient.dossierMedical.consultations'])->first();

        if (!$user || !$user->patient) {
            return redirect()->back()->with('error', "Aucun patient trouvé avec la CNI : $cni");
        }

        $patient = $user->patient;
        
        // On redirige vers la vue du dossier détaillée que nous avons créée
        return view('dashboard.medecin.dossier_detail', compact('patient'));
    }

    /**
     * Permet de prendre un rendez-vous via le web
     */
    public function prendre_rdv(Request $request)
    {
        $request->validate([
            'date_heure' => 'required|date|after:now',
            'motif'      => 'required|string|min:5'
        ]);

        // On récupère le patient connecté (ou via la CNI si c'est la secrétaire)
        $patient = Auth::user()->patient;

        if (!$patient) {
            return redirect()->back()->with('error', "Profil patient incomplet.");
        }

        $medecin = Medecin::first(); 

        RendezVous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_heure' => $request->date_heure,
            'motif'      => $request->motif,
            'statut'     => 'en attente',
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Rendez-vous enregistré !');
    }
    public function rechercheParCni(Request $request)
    {
        $request->validate(['cni' => 'required|string']);

        // 1. On cherche d'abord l'utilisateur par sa CNI
        $user = \App\Models\User::where('cni', $request->cni)->first();

        // 2. Si l'utilisateur n'existe pas ou n'a pas de profil patient lié
        if (!$user || !$user->patient) {
            return redirect()->back()->with('error', 'Aucun patient trouvé avec cette CNI.');
        }

        // 3. On redirige vers le dossier du patient lié à cet utilisateur
        return redirect()->route('medecin.dossier', $user->patient->id);
    }

    public function voirDossier($id)
    {
        $patient = Patient::with(['user', 'dossierMedical.consultations'])->findOrFail($id);
        
        // On trie les consultations par date, les plus récentes d'abord
        $consultations = $patient->dossierMedical->consultations->sortByDesc('created_at');
        
        return view('dashboard.medecin.patients.dossier', compact('patient', 'consultations'));
    }

    public function createConsultation($patient_id)
    {
        $patient = Patient::findOrFail($patient_id);
        // Ici, tu affiches la vue contenant le formulaire
        return view('dashboard.medecin.consultation_form', compact('patient'));
    }


    public function storeConsultation(Request $request)
    {
        // 1. Validation : Vérifie que le patient existe et que les données sont là
        $request->validate([
            'patient_id'   => 'required|exists:patients,id',
            'observations' => 'required|string',
            'rendezvous_id'=> 'nullable|exists:rendez_vous,id',
        ]);

        // 2. Récupération du dossier médical du patient
        // firstOrCreate permet de créer le dossier s'il n'existe pas encore
        $patient = \App\Models\Patient::findOrFail($request->patient_id);
        $dossier = \App\Models\DossierMedical::firstOrCreate(['patient_id' => $patient->id]);

        // 3. Création de la consultation
        // On utilise les noms de colonnes réels de ta migration
        \App\Models\Consultation::create([
            'dossier_medical_id' => $dossier->id,
            'rendezvous_id'      => $request->rendezvous_id ?? null,
            'date_consultation'  => now(),            // Obligatoire : Date actuelle
            'compte_rendu'       => $request->observations, // 'observations' devient 'compte_rendu'
        ]);

        return redirect()->route('medecin.dossier', $request->patient_id)
                        ->with('success', 'Consultation enregistrée avec succès.');
    }

    public function store(Request $request)
    {
        // 1. Validation : Assure-toi que les champs obligatoires sont présents
        $request->validate([
            'observations'  => 'required|string', // Sera mappé sur compte_rendu
            'rendezvous_id' => 'required|exists:rendez_vous,id', // Obligatoire selon ta migration
        ]);

        // 2. Création de la consultation avec les champs exacts de la migration
        \App\Models\Consultation::create([
            'rendezvous_id'     => $request->rendezvous_id,
            'date_consultation' => now(), // Ajout de la date actuelle obligatoire
            'compte_rendu'      => $request->observations, // Mappage de observations vers compte_rendu
        ]);

        return redirect()->back()->with('success', 'Consultation enregistrée avec succès.');
    }


    public function storeOrdonnance(Request $request)
    {
        $request->validate([
            'consultation_id' => 'required|exists:consultations,id',
            'contenu'         => 'required|string',
        ]);

        $consultation = \App\Models\Consultation::findOrFail($request->consultation_id);

        // Utilise la méthode 'genererOrdonnance' que tu as déjà dans ton modèle Consultation
        $consultation->genererOrdonnance($request->contenu);

        return redirect()->back()->with('success', 'Ordonnance créée avec succès.');
    }


    public function dashboard()
    {
        $user = Auth::user();
        $patient = $user->patient;

        // 1. Sécurité : Vérifier si le profil patient existe
        if (!$patient) {
            // Redirige vers une page d'erreur ou affiche un message si le profil est incomplet
            return redirect()->back()->with('error', 'Votre profil patient est incomplet ou introuvable.');
        }

        // 2. Compter les rendez-vous (le code est maintenant sûr car $patient existe)
        $nbrRendezvous = \App\Models\RendezVous::where('patient_id', $patient->id)->count();

        // 3. Compter les consultations
        $nbrConsultations = \App\Models\Consultation::whereHas('rendezvous', function($q) use ($patient) {
        $q->where('patient_id', $patient->id);
    })->count();

        // 4. Récupérer les 3 derniers rendez-vous
        $derniersRdv = \App\Models\RendezVous::where('patient_id', $patient->id)
                        ->latest()
                        ->limit(8)
                        ->get();

        return view('dashboard.patient.index', compact('nbrRendezvous', 'nbrConsultations', 'derniersRdv'));
    }

    public function indexConsultations()
{
    $user = Auth::user();

    // 1. Vérification : Est-ce qu'on a bien un patient ?
    if (!$user->patient) {
        return redirect()->back()->with('error', 'Vous n\'avez pas de profil patient associé.');
    }

    // 2. Maintenant, on peut accéder à $user->patient->id sans risque
    $patientId = $user->patient->id;

    $consultations = \App\Models\Consultation::whereHas('rendezvous', function($q) use ($patientId) {
        $q->where('patient_id', $patientId);
    })->latest()->get();

    return view('dashboard.patient.consultations.index', compact('consultations'));
}

    // public function indexConsultations()
    // {
    //     $patient = Auth::user()->patient;
    //     $consultations = \App\Models\Consultation::whereHas('rendezvous', function($q) use ($patient) {
    //         $q->where('patient_id', $patient->id);
    //     })->latest()->get();

    //     return view('dashboard.patient.consultations.index', compact('consultations'));
    // }

    
    public function showConsultation($id)
    {
        $consultation = \App\Models\Consultation::findOrFail($id);
        return view('dashboard.patient.consultations.show', compact('consultation'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('dashboard.patient.profile.edit', compact('user'));
    }
}
