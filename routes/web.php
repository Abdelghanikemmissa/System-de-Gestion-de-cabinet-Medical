<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecretaireController;

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
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.submit');


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
    Route::get('consultation/create/{rendezvous_id}', [MedecinController::class, 'createConsultation'])
     ->name('medecin.consultation.create');
    
    Route::get('/consultation/create/{patient_id}', [ConsultationController::class, 'create'])
         ->name('consultation.create');
    


    // 2. Enregistre la consultation (POST) - Une seule route vers le ConsultationController
    Route::post('/consultation/store', [ConsultationController::class, 'store'])
         ->name('consultation.store');
    
    // 3. Ordonnances
    Route::post('/ordonnance/store', [PatientController::class, 'storeOrdonnance'])
         ->name('ordonnance.store');
    Route::delete('/disponibilites/{id}', [MedecinController::class, 'destroy'])->name('dispo.destroy');
    
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.show');


    Route::get('/ordonnance/{id}/pdf', function ($id) {
    $ordonnance = \App\Models\Ordonnance::findOrFail($id);
    return $ordonnance->genererDocumentPDF();
})->name('ordonnance.pdf');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/secretaire/dashboard', [SecretaireController::class, 'showDashboard'])->name('secretaire.dashboard');
    Route::get('/secretaire/patients', [SecretaireController::class, 'indexPatients'])->name('secretaire.patients');
    
    // Appointment Management
    Route::get('/secretaire/rendez-vous', [SecretaireController::class, 'indexRendezVous'])->name('secretaire.rendezvous');
    Route::get('/secretaire/planning-data', [SecretaireController::class, 'voirPlanning'])->name('secretaire.planning.data');
    
    Route::post('/rendezvous/confirmer/{id}', [SecretaireController::class, 'confirmerRendezVous'])->name('secretaire.confirmer');
    Route::post('/rendezvous/annuler/{id}', [SecretaireController::class, 'annulerRendezVous'])->name('secretaire.annuler');

    Route::get('/secretaire/create', function () {
        return view('secretaire.create');
    })->name('secretaire.create');

    Route::post('/secretaire/ajouter', [SecretaireController::class, 'ajouterNouveauPatient'])
         ->name('secretaire.ajouter');
    
});

Route::middleware(['auth'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    
    // Rendez-vous
    Route::get('/rdv/create', fn() => view('dashboard.patient.rendez_vous.create'))->name('rdv.create');
    Route::post('/rdv/store', [PatientController::class, 'prendre_rdv'])->name('rdv.store');
    // filtrer les rendez-vous
    Route::get('/rendezvous', [RendezVousController::class, 'indexRendezvous'])->name('rendezvous');
    // Consultations
    Route::get('/consultations', [PatientController::class, 'indexConsultations'])->name('consultations.index');
    Route::get('/consultations/{id}', [PatientController::class, 'showConsultation'])->name('consultations.show');

    Route::get('/profile/edit', [PatientController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'updateProfilePatient'])->name('profile.update');
});



use App\Http\Controllers\AdminController;

// Update your existing admin group to include the 'isAdmin' middleware
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/staff/store', [AdminController::class, 'storeStaff'])->name('staff.store');
    // Add other admin routes here...
});



