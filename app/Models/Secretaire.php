<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class Secretaire extends Model
{
    protected $fillable = ['user_id']; // Pas d'ID ici

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Logique pour valider un rendez-vous (Action de la secrétaire)
     */
    public function validerRendezVous(int $rendezVousId): bool
    {
        // 1. Trouver le rendez-vous
        $rdv = RendezVous::find($rendezVousId);

        if (!$rdv) {
            return false; // Le rendez-vous n'existe pas
        }

        // 2. Utiliser la méthode confirmer() du modèle RendezVous
        // C'est ici que le statut passe à "confirmé" et que l'email est envoyé
        $rdv->confirmer();

        return true;
    }

    /**
     * Crée tout l'écosystème d'un patient de manière sécurisée
     */
    public function creerFicheEtDossier(string $cni, array $data): void
    {
        // On utilise une transaction pour éviter les données incomplètes en cas d'erreur
        DB::transaction(function () use ($cni, $data) {
            
            // 1. Création de l'utilisateur
            $user = User::create([
                'cni'      => $cni,
                'nom'      => $data['nom'],
                'prenom'   => $data['prenom'],
                'email'    => $data['email'],
                'password' => Hash::make('password123'), // Mot de passe par défaut
                'role'     => 'patient',
            ]);

            // 2. Création du profil Patient
            $patient = Patient::create([
                'user_id'        => $user->id,
                'date_naissance' => $data['date_naissance'],
                'telephone'      => $data['telephone'],
                'adresse'        => $data['adresse'],
                'sexe'           => $data['sexe']
            ]);

            // 3. Création du Dossier Médical
            DossierMedical::create([
                'patient_id' => $patient->id,
                'historique' => 'Dossier ouvert le ' . now()->format('d/m/Y')
            ]);
        });
    }
}