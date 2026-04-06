<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medecin;
use App\Models\Disponibilite;
use App\Models\DossierMedical;
use App\Models\Consultation;
use App\Models\RendezVous;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MedecinController extends Controller
{
    /**
     * Définit les créneaux libres du médecin connecté
     */
    public function definirDisponibilites(Request $request)
    {
        $request->validate([
            '*.jour'        => 'required|date|after_or_equal:today',
            '*.heure_debut' => 'required',
            '*.heure_fin'   => 'required|after:*.heure_debut',
        ]);

        // Sécurité : on prend l'ID du médecin connecté via son compte User
        $medecinId = Auth::user()->medecin->id;
        $creneauxCrees = [];

        foreach ($request->all() as $item) {
            // Vérification doublon
            $existe = Disponibilite::where('medecin_id', $medecinId)
                ->where('jour', $item['jour'])
                ->where('heure_debut', $item['heure_debut'])
                ->exists();

            if (!$existe) {
                $creneauxCrees[] = Disponibilite::create([
                    'medecin_id'  => $medecinId,
                    'jour'        => $item['jour'],
                    'heure_debut' => $item['heure_debut'],
                    'heure_fin'   => $item['heure_fin'],
                    'est_libre'   => true
                ]);
            }
        }

        return response()->json(['message' => count($creneauxCrees) . ' créneaux ajoutés.'], 201);
    }

    /**
     * Récupère le planning complet avec Infos Médecin
     */
    public function getDisponibilites()
    {
        // On utilise Query Builder pour lier les tables
        $planning = DB::table('disponibilites')
            ->join('medecins', 'medecins.id', '=', 'disponibilites.medecin_id')
            ->join('users', 'users.id', '=', 'medecins.user_id')
            ->select(
                'users.nom as nom_medecin', 
                'users.prenom as prenom_medecin',
                'medecins.specialite',
                'disponibilites.jour',
                'disponibilites.heure_debut',
                'disponibilites.heure_fin'
            )
            ->orderBy('disponibilites.jour', 'asc')
            ->orderBy('disponibilites.heure_debut', 'asc')
            ->get();

        if ($planning->isEmpty()) {
            return response()->json([
                'message' => 'Aucune disponibilité trouvée pour le moment.'
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $planning
        ], 200);
    }

    /**
     * L'acte médical : crée la consultation et l'ordonnance liée
     */
    public function creerConsultation(Request $request)
    {
        $fields = $request->validate([
            'rendezvous_id'      => 'required|exists:rendez_vous,id',
            'patient_id'         => 'required|exists:patients,id',
            'compte_rendu'       => 'required|string',
            'contenu_ordonnance' => 'nullable|string', // Optionnel
        ]);

        $dossier = DossierMedical::where('patient_id', $fields['patient_id'])->first();

        if (!$dossier) {
            return response()->json(['message' => 'Dossier médical introuvable'], 404);
        }

        // 1. Création de la Consultation (Liaison Dossier + RDV)
        $consultation = Consultation::create([
            'rendezvous_id'      => $fields['rendezvous_id'],
            'dossier_medical_id' => $dossier->id,
            'date_consultation'  => now(),
            'compte_rendu'       => $fields['compte_rendu'],
        ]);

        // 2. Création de l'ordonnance (uniquement si le contenu est fourni)
        if (!empty($fields['contenu_ordonnance'])) {
            // On utilise la méthode métier qu'on a mise dans le modèle Consultation
            $consultation->genererOrdonnance($fields['contenu_ordonnance']);
        }

        // 3. Mise à jour du statut du RDV
        RendezVous::where('id', $fields['rendezvous_id'])->update(['statut' => 'terminé']);

        return response()->json([
            'message' => 'Consultation et ordonnance enregistrées.',
            'data' => $consultation->load('ordonnance')
        ], 201);
    }
}