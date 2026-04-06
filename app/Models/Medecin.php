<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medecin extends Model
{
    // On retire 'id' pour plus de sécurité
    protected $fillable = ['user_id', 'specialite'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation avec les créneaux horaires
    public function disponibilites(): HasMany
    {
        return $this->hasMany(Disponibilite::class, 'medecin_id');
    }

    // Relation avec les rendez-vous pris
    public function rendezVous(): HasMany
    {
        return $this->hasMany(RendezVous::class, 'medecin_id');
    }
}