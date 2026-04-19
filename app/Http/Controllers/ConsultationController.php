<?php
namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Ordonnance;
use App\Models\Patient;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    /**
     * AFFICHER le formulaire pour une nouvelle consultation
     */
    public function create($patient_id)
    {
        $patient = Patient::with('user')->findOrFail($patient_id);
        return view('dashboard.medecin.consultations.create', compact('patient'));
    }

    /**
     * ENREGISTRER une nouvelle consultation
     */
    public function store(Request $request)
{
    $request->validate([
        'patient_id'   => 'required|exists:patients,id',
        'compte_rendu' => 'required|string',
        
    ]);

    $patient = \App\Models\Patient::findOrFail($request->patient_id);
    
    // SÉCURITÉ : Récupère le dossier ou le crée s'il n'existe pas
    $dossier = \App\Models\DossierMedical::firstOrCreate(['patient_id' => $patient->id]);

    \App\Models\Consultation::create([
        'dossier_medical_id' => $dossier->id,
        'compte_rendu'       => $request->compte_rendu,
        'date_consultation'  => now(), 
    ]);

    return redirect()->route('medecin.dossier', $patient->id)
                     ->with('success', 'Consultation enregistrée !');
}
    /**
     * AFFICHER le formulaire de modification
     */
    public function edit($id)
    {
        // On charge la consultation avec l'ordonnance et les infos du patient
        $consultation = Consultation::with(['ordonnance', 'patient.user'])->findOrFail($id);
        return view('dashboard.medecin.consultations.edit', compact('consultation'));
    }

    /**
     * METTRE À JOUR une consultation existante
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'observations' => 'required|string|min:10',
            'contenu_ordonnance' => 'nullable|string'
        ]);

        $consultation = Consultation::findOrFail($id);
        
        // 1. Mise à jour des observations
        $consultation->update([
            'observations' => $request->observations
        ]);

        // 2. Gestion de l'ordonnance (Création ou Mise à jour)
        if ($request->filled('contenu_ordonnance')) {
            Ordonnance::updateOrCreate(
                ['consultation_id' => $consultation->id],
                ['contenu' => $request->contenu_ordonnance]
            );
        }

        return redirect()->route('medecin.dossier', $consultation->patient_id)
                         ->with('success', 'Consultation mise à jour avec succès.');
    }

    
}