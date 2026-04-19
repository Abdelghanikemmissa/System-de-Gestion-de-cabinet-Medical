<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Http\Controllers\Consultation;

class Patient extends Model
{
    protected $fillable = [
        'user_id', 
        'date_naissance', 
        'telephone', 
        'adresse', 
        'sexe' 
    ];

    /**
     * Conversion automatique des types
     */
    protected $casts = [
        'date_naissance' => 'date',
    ];

    /**
     * Relation vers le modèle User (One-to-One ou BelongsTo)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation vers les rendez-vous
     */
    public function rendezVous(): HasMany
    {
        return $this->hasMany(RendezVous::class);
    }

    /**
     * Relation vers le dossier médical
     */
    public function dossierMedical(): HasOne
    {
        return $this->hasOne(DossierMedical::class);
    }

    /**
     * Relation vers les consultations
     */
public function consultations()
{
    // Un patient a des consultations A TRAVERS ses rendez-vous
    return $this->hasManyThrough(
        Consultation::class,   // Modèle final qu'on veut récupérer
        RendezVous::class,     // Modèle intermédiaire
        'patient_id',          // Clé étrangère sur la table rendez_vous
        'rendezvous_id',       // Clé étrangère sur la table consultations
        'telephone', // <-- Ajoute bien ces champs
            'adresse',   // <-- ici
            'sexe'       // <-- ici
    );
}
public function scopeRechercher($query, $search) {
    return $query->whereHas('user', function($q) use ($search) {
        $q->where('nom', 'like', "%{$search}%")
          ->orWhere('cni', 'like', "%{$search}%");
    });
}

}