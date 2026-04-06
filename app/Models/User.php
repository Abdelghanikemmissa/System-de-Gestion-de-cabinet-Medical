<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable; 
use Laravel\Sanctum\HasApiTokens;// Indispensable pour tester avec Postman plus tard

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'cni',
        'nom',
        'prenom',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Opérations de ton UML
    
    /**
     * Simulation de l'opération login()
     */
    public function login()
    {
        // La logique de session ou Token sera gérée dans le Controller
        return true;
    }

    /**
     * Simulation de l'opération logout()
     */
    public function logout()
    {
        // La logique de déconnexion
    }
    public function patient()
    {
        // Vérifie que 'user_id' est bien le nom de la colonne dans ta table 'patients'
        return $this->hasOne(Patient::class, 'user_id');
    }
    public function medecin()
    {
        return $this->hasOne(Medecin::class, 'user_id');
    }

    public function secretaire()
    {
        return $this->hasOne(Secretaire::class, 'user_id');
    }
    
    public function isPatient()
    {
        return $this->role === 'patient';
    }

    public function isMedecin()
    {
        return $this->role === 'medecin';
    }

    public function isSecretaire()
    {
        return $this->role === 'secretaire';
    }
}