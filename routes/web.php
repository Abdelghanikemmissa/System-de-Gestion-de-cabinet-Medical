<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SecretaireController;

// Authentication
Route::get('/auth/login', function () {
    return view('auth.login'); // Updated to point to auth/login.blade.php
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/secretaire/dashboard', [SecretaireController::class, 'showDashboard'])->name('secretaire.dashboard');
    Route::get('/secretaire/patients', [SecretaireController::class, 'indexPatients'])->name('secretaire.patients');
    
    // Appointment Management
    Route::get('/secretaire/rendez-vous', [SecretaireController::class, 'indexRendezVous'])->name('secretaire.rendezvous');
    Route::post('/secretaire/rendez-vous/valider/{id}', [SecretaireController::class, 'validerRendezVous'])->name('secretaire.valider');
    Route::post('/secretaire/rendez-vous/annuler/{id}', [SecretaireController::class, 'annulerRendezVous'])->name('secretaire.annuler');
});