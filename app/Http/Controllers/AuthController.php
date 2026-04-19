<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}