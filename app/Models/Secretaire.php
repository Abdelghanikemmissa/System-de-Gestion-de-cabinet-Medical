<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class Secretaire extends Model
{
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function validerRendezVous(int $rendezVousId): bool
    {
        $rdv = RendezVous::find($rendezVousId);
        if (!$rdv) return false;

        $rdv->confirmer(); 
        return true;
    }

    public function creerFicheEtDossier(string $cni, array $data): void
    {
        DB::transaction(function () use ($cni, $data) {
            $user = User::create([
                'cni'      => $cni,
                'nom'      => $data['nom'],
                'prenom'   => $data['prenom'],
                'email'    => $data['email'],
                'password' => Hash::make('password123'),
                'role'     => 'patient',
            ]);

            $patient = Patient::create([
                'user_id'        => $user->id,
                'date_naissance' => $data['date_naissance'],
                'telephone'      => $data['telephone'],
                'adresse'        => $data['adresse'],
                'sexe'           => $data['sexe']
            ]);

            DossierMedical::create([
                'patient_id' => $patient->id,
                'historique' => 'Dossier ouvert le ' . now()->format('d/m/Y')
            ]);
        });
    }
}