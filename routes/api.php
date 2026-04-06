<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\usercontroller;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SecretaireController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\OrdonnanceController;
use App\Http\Controllers\DossierMedicalController;
use App\Http\Controllers\RendezVousController;

/*
|--------------------------------------------------------------------------
| 1. ROUTES PUBLIQUES (Sans Token)
|--------------------------------------------------------------------------
*/
// Inscription et Connexion
Route::post('/register', [usercontroller::class, 'createuser']);
Route::post('/login', [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| 2. ROUTES PROTÉGÉES (Nécessitent le Bearer Token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // --- AUTHENTIFICATION ---
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- ESPACE PATIENT ---
    Route::prefix('patient')->group(function () {
        Route::get('/profile/{cni}', [PatientController::class, 'searchByCni']);
        Route::post('/rdv/prendre', [PatientController::class, 'prendreRendezVous']);
        Route::get('/mon-dossier/{cni}', [DossierMedicalController::class, 'consulterParCni']);
        Route::get('/mes-rendezvous/{cni}', [PatientController::class, 'mesRendezVous']);
    });

    // --- ESPACE SECRÉTAIRE ---
    Route::prefix('secretaire')->group(function () {
        Route::get('/liste-patients', [PatientController::class, 'index']);
        Route::post('/patient/creer', [SecretaireController::class, 'ajouterNouveauPatient']);
        Route::post('/rdv/{id}/valider', [SecretaireController::class, 'validerRendezVous']);
    });

    // --- ESPACE MÉDECIN ---
    Route::prefix('medecin')->group(function () {
        // Gestion du calendrier
        Route::post('/disponibilites', [MedecinController::class, 'definirDisponibilites']);
        Route::get('/disponibilites', [MedecinController::class, 'getDisponibilites']);
        
        // Acte médical
        Route::post('/consultation/creer', [MedecinController::class, 'creerConsultation']);
        Route::get('/dossier-patient/{cni}', [DossierMedicalController::class, 'consulterParCni']);
    });

    // --- GESTION DES RENDEZ-VOUS (Actions communes) ---
    Route::prefix('rdv')->group(function () {
        Route::post('/{id}/confirmer', [RendezVousController::class, 'confirmer']);
        Route::post('/{id}/annuler', [RendezVousController::class, 'annuler']);
        Route::post('/{id}/notifier', [RendezVousController::class, 'envoyerNotification']);
    });

    // --- DOCUMENTS & ORDONNANCES ---
    Route::post('/consultation/{id}/ordonnance', [ConsultationController::class, 'genererOrdonnance']);
    Route::get('/ordonnance/{id}/pdf', [OrdonnanceController::class, 'exportPDF']);

});