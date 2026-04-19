<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ConsultationController;

/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Espace Médecin (Protégé par Auth)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('medecin')->name('medecin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [MedecinController::class, 'index'])->name('index');
    // Dans routes/web.php, à l'intérieur du groupe Route::middleware(['auth'])->prefix('medecin')...
Route::get('/recherche-cni', [MedecinController::class, 'rechercheCni'])->name('recherche');

    // Gestion des Patients
    Route::get('/patients', [PatientController::class, 'index'])->name('patients');
    Route::post('/patients/recherche', [PatientController::class, 'rechercheParCni'])->name('rechercheCni');
    Route::get('/dossier/{id}', [PatientController::class, 'voirDossier'])->name('dossier');

    Route::get('/disponibilites', [MedecinController::class, 'indexDispo'])->name('dispo.index');

    // Planning
    Route::get('/planning', [MedecinController::class, 'voirPlanning'])->name('planning');
    Route::post('/planning/store', [MedecinController::class, 'storeDispo'])->name('dispo.store');

    // --- Routes de Consultation ---
    
// 1. Affiche le formulaire (GET)
    Route::get('/consultation/create/{patient_id}', [ConsultationController::class, 'create'])
         ->name('consultation.create');

    // 2. Enregistre la consultation (POST) - Une seule route vers le ConsultationController
    Route::post('/consultation/store', [ConsultationController::class, 'store'])
         ->name('consultation.store');
    
    // 3. Ordonnances
    Route::post('/ordonnance/store', [PatientController::class, 'storeOrdonnance'])
         ->name('ordonnance.store');
    Route::delete('/disponibilites/{id}', [MedecinController::class, 'destroy'])->name('dispo.destroy');
    



    Route::get('/ordonnance/{id}/pdf', function ($id) {
    $ordonnance = \App\Models\Ordonnance::findOrFail($id);
    return $ordonnance->genererDocumentPDF();
})->name('ordonnance.pdf');
});

use App\Http\Controllers\SecretaireController;


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
