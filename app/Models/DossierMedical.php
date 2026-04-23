<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DossierMedical extends Model
{
    protected $table = 'dossier_medicals';

    // Garde 'patient_id' et 'historique' (ou les champs de ta migration).
    protected $fillable = ['patient_id', 'historique'];

    /*
     * Un dossier possède plusieurs consultations.
     */
    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class, 'dossier_medical_id');
    }

    /**
     * RELATION : Le dossier appartient à un patient unique
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    /**
     * Méthode métier
     */
    public function consulter(): void
    {
        logger("Consultation du dossier ID: " . $this->id);
    }
}