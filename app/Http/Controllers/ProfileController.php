<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

public function show()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }
    public function edit() {
        return view('profile.edit');
    }

    public function update(Request $request) {
        $user = auth()->user();
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user->nom = $request->nom;
        $user->prenom = $request->prenom;

        if ($request->hasFile('photo')) {
            // Suppression de l'ancienne photo si elle existe
            if ($user->photo) Storage::disk('public')->delete($user->photo);
            
            $path = $request->file('photo')->store('avatars', 'public');
            $user->photo = $path;
        }

        $user->save();
        return back()->with('success', 'Profil mis à jour avec succès !');
    }


    public function updateProfilePatient(Request $request) {
    $user = Auth::user();
    $patient = $user->patient;

    // 1. Validation incluant la photo
    $request->validate([
        'telephone' => 'required|string|max:20',
        'adresse'   => 'required|string|max:255',
        'password'  => 'nullable|min:6|confirmed',
        'photo'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2 Mo max
    ]);

    // 2. Gestion de la photo
    if ($request->hasFile('photo')) {
        // Suppression de l'ancienne photo si elle existe
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }
        
        // Enregistrement de la nouvelle photo
        $path = $request->file('photo')->store('avatars', 'public');
        $user->photo = $path;
    }

    // 3. Mise à jour des informations spécifiques au patient
    if ($patient) {
        $patient->update([
            'telephone' => $request->telephone,
            'adresse'   => $request->adresse,
        ]);
    }

    // 4. Mise à jour du mot de passe si fourni
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    // 5. Sauvegarde des modifications du user (nom/prénom/photo/mdp)
    $user->save();

    return redirect()->back()->with('success', 'Profil et photo mis à jour avec succès !');
}
} 
