<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RendezVous extends Model
{
    protected $table = 'rendez_vous';

    protected $fillable = ['patient_id', 'medecin_id', 'date_heure', 'statut'];

    // Pour que Laravel transforme automatiquement la colonne en objet Date
    protected $casts = [
        'date_heure' => 'datetime',
    ];

    /**
     * Confirmer le rendez-vous
     */
    public function confirmer(): void
    {
        $this->update(['statut' => 'confirmé']);
    }

    /**
     * Annuler le rendez-vous
     */
    public function annuler(): void
    {
        $this->update(['statut' => 'annulé']);
    }

    // --- RELATIONS ---

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function medecin(): BelongsTo
    {
        return $this->belongsTo(Medecin::class, 'medecin_id');
    }
}