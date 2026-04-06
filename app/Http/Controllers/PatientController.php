<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\RendezVous;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Disponibilite;

class PatientController extends Controller
{
    /**
     * Liste tous les patients avec leurs informations personnelles.
     * Utile pour le tableau de bord de la secrétaire.
     */
    public function index()
    {
        $patients = DB::table('patients')
            ->join('users', 'users.id', '=', 'patients.user_id')
            ->select(
                'users.nom', 
                'users.prenom', 
                'users.cni', 
                'patients.adresse', 
                'patients.sexe', 
                'patients.telephone'
            )
            ->get();

        return response()->json([
            'status' => 'success',
            'count'  => $patients->count(),
            'data'   => $patients
        ], 200);
    }

    /**
     * Recherche un patient spécifique par sa CNI.
     * Retourne un profil complet (User + Patient) sans les données sensibles.
     */
    public function searchByCni($cni)
    {
        // On récupère l'utilisateur et son profil patient associé en une seule fois
        $user = User::where('cni', $cni)->with('patient')->first();

        if (!$user || !$user->patient) {
            return response()->json([
                'message' => "Aucun patient trouvé avec la CNI : $cni"
            ], 404);
        }

        // Fusion des données de l'User et du Patient
        $data = array_merge($user->toArray(), $user->patient->toArray());

        // SÉCURITÉ : On retire les champs techniques et sensibles
        unset(
            $data['id'], 
            $data['user_id'], 
            $data['password'], 
            $data['email_verified_at'], 
            $data['created_at'], 
            $data['updated_at']
        );

        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }

    /**
     * Permet à un patient de prendre un rendez-vous.
     * Vérifie l'existence du patient et d'un médecin disponible.
     */
    public function prendreRendezVous(Request $request)
    {
        // 1. Validation des données entrantes
        $fields = $request->validate([
            'cni'        => 'required|exists:users,cni',
            'date_heure' => 'required|date|after:now', // Empêche les RDV dans le passé
            'motif'      => 'required|string|min:5'
        ]);

        // 2. Récupération du profil complet
        $user = User::where('cni', $fields['cni'])->first();

        if (!$user->patient) {
            return response()->json([
                'message' => "L'utilisateur existe mais n'a pas de profil Patient complété."
            ], 403);
        }

        // 3. Vérification de la présence d'un médecin (Sécurité anti-crash)
        $medecin = Medecin::first();
        if (!$medecin) {
            return response()->json([
                'message' => "Action impossible : Aucun médecin n'est configuré dans le système."
            ], 500);
        }

        // 4. Création du Rendez-vous
        $rdv = RendezVous::create([
            'patient_id' => $user->patient->id,
            'medecin_id' => $medecin->id,
            'date_heure' => $fields['date_heure'],
            'motif'      => $fields['motif'],
            'statut'     => 'en attente',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Rendez-vous enregistré avec succès pour ' . $user->nom . ' ' . $user->prenom,
            'data'    => $rdv
        ], 201);
    }

    public function mesRendezVous($cni)
    {
        // 1. Trouver l'utilisateur par sa CNI
        $user = User::where('cni', $cni)->first();

        if (!$user || !$user->patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient non trouvé.'
            ], 404);
        }

        // 2. Récupérer les rendez-vous
        $rendezvous = RendezVous::where('patient_id', $user->patient->id)
            ->with('medecin.user') 
            ->orderBy('date_heure', 'desc')
            ->get();

        // --- AJOUT : Vérification si la liste est vide ---
        if ($rendezvous->isEmpty()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Vous n\'avez aucun rendez-vous.',
                'data'    => [] 
            ]);
        }

        // 3. Transformer les données si elles existent
        $dataSimplifiee = $rendezvous->map(function ($rdv) {
            return [
                'date_heure' => $rdv->date_heure,
                'statut'     => $rdv->statut,
                'nom_medecin' => $rdv->medecin && $rdv->medecin->user 
                                ? 'Dr. ' . $rdv->medecin->user->nom 
                                : 'Médecin non assigné'
            ];
        });

        return response()->json([
            'status'  => 'success',
            'data'    => $dataSimplifiee
        ]);
    }

}