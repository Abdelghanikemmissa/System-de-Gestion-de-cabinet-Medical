<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;      // <--- AJOUTE CETTE LIGNE
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomePatient; // N'oublie pas l'import


class AuthController extends Controller
{
    // Affiche la vue de login
    public function showLogin() {
        return view('auth.login');
    }

    // Gère la connexion avec redirection par rôle
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirection dynamique selon le rôle
            return match ($user->role) {
                'medecin'    => redirect()->intended('/medecin/dashboard'),
                'secretaire' => redirect()->intended('/secretaire/dashboard'),
                'patient'    => redirect()->intended('/patient/dashboard'),
                default      => redirect()->intended('/'),
            };
        }

        return back()->withErrors([
            'email' => 'Les identifiants sont incorrects.',
        ])->onlyInput('email');
    }

    // Gère la déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function signup(Request $request)
{
    $data = $request->validate([
        'nom' => 'required|string',
        'prenom' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'cni' => 'required|unique:users',
        'telephone' => 'required',
        'date_naissance' => 'required|date',
        'sexe' => 'required|in:M,F',
        'adresse' => 'required',
    ]);

    // 1. Création du User
    $user = User::create([
        'nom' => $data['nom'],
        'prenom' => $data['prenom'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'cni' => $data['cni'],
        'role' => 'patient', // Rôle par défaut
    ]);

    // 2. Création du Patient
    Patient::create([
        'user_id' => $user->id,
        'telephone' => $data['telephone'],
        'date_naissance' => $data['date_naissance'],
        'sexe' => $data['sexe'],
        'adresse' => $data['adresse'],
    ]);

    // 3. Notification par email
    Mail::to($user->email)->send(new WelcomePatient($user));

    return redirect()->route('login')->with('success', 'Inscription terminée !');
}
public function showSignup() {
    return view('auth.signup');
}
}