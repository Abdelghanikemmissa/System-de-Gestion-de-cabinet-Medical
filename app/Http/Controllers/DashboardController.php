<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Medecin;
use App\Models\RendezVous;
use App\Models\Consultation;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques
        $totalPatients = Patient::count();
        $totalMedecins = Medecin::count();
        $todayAppointments = RendezVous::whereDate('date_heure', Carbon::today())->count();
        $consultations = Consultation::count();

        // Rendez-vous aujourd’hui
        $rdvs = RendezVous::with(['patient.user', 'medecin.user'])
            ->whereDate('date_heure', Carbon::today())
            ->orderBy('date_heure', 'asc')
            ->get();

        // Derniers patients
        $patients = Patient::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalPatients',
            'totalMedecins',
            'todayAppointments',
            'consultations',
            'rdvs',
            'patients'
        ));
    }
}