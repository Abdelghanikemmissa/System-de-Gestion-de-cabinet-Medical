<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disponibilite extends Model
{
    protected $fillable = [
        'medecin_id', 
        'jour', 
        'heure_debut', 
        'heure_fin', 
        'est_libre'
    ];

    protected $casts = [
        'jour' => 'date',
        'est_libre' => 'boolean',
    ];

    // Relation : Une disponibilité appartient à un médecin
    public function medecin(): BelongsTo
    {
        return $this->belongsTo(Medecin::class, 'medecin_id');
    }

    /**
     * Filtre pour ne récupérer que les créneaux disponibles
     */
    public function scopeLibre($query)
    {
        return $query->where('est_libre', true);
    }
}