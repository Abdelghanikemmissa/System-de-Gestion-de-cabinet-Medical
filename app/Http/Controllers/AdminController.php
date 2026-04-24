<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Medecin;
use App\Models\Secretaire;
use App\Models\Admin;
use App\Models\Patient;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
public function dashboard()
    {
        $stats = [
            'total_medecins' => Medecin::count(),
            'total_secretaires' => Secretaire::count(),
            'total_patients' => Patient::count(),
            'total_rdv' => RendezVous::count(),
            'rdv_confirmes' => RendezVous::where('statut', 'confirmé')->count(),
        ];

        // Récupérer les listes pour le tableau de bord
        $medecins = Medecin::with('user')->get();
        $patients = Patient::all();

        return view('admin.dashboard', compact('stats', 'medecins', 'patients'));
    }

    public function storeStaff(Request $request)
    {
        // Note: Using 'cni' lowercase to match your rename migration
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:medecin,secretaire,admin',
            'cni' => 'required|unique:users,cni', 
            'specialite' => 'required_if:role,medecin'
        ]);

        $user = User::create([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'cni' => $data['cni'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        // Logic based on nomination/role
        if ($data['role'] === 'medecin') {
            Medecin::create([
                'user_id' => $user->id,
                'specialite' => $data['specialite']
            ]);
        } elseif ($data['role'] === 'secretaire') {
            Secretaire::create([
                'user_id' => $user->id
            ]);
        } elseif ($data['role'] === 'admin') {
            Admin::create([
                'user_id' => $user->id
            ]);
        }

        return redirect()->back()->with('success', 'Membre ajouté avec succès !');
    }

    public function listMedecins()
    {
        $medecins = Medecin::with('user')->get(); // 'with' charge les infos utilisateur liées
        return view('admin.medecins.index', compact('medecins'));
    }

    // Pour afficher la liste des patients
    public function listPatients()
    {
        $patients = Patient::all();
        return view('admin.patients.index', compact('patients'));
    }
}