<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consultation extends Model
{
    protected $fillable = [
        'rendezvous_id', 
        'dossier_medical_id', 
        'date_consultation', 
        'compte_rendu'
    ];

    // Pour que le frontend reçoive des dates propres
    protected $casts = [
        'date_consultation' => 'datetime',
    ];

    /**
     * Relation avec l'ordonnance
     */
    public function ordonnance(): HasOne
    {
        return $this->hasOne(Ordonnance::class, 'consultation_id');
    }

    /**
     * Génère une ordonnance liée à cette consultation
     */
    public function genererOrdonnance(string $contenu): Ordonnance
    {
        return $this->ordonnance()->create([
            'contenu' => $contenu,
        ]);
    }

    /**
     * Relation vers le rendez-vous
     */
    public function rendezvous(): BelongsTo
    {
        return $this->belongsTo(RendezVous::class, 'rendezvous_id');
    }

    /**
     * Relation vers le dossier médical du patient
     */
    public function dossier(): BelongsTo
    {
        return $this->belongsTo(DossierMedical::class, 'dossier_medical_id');
    }

}