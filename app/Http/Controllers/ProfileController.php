<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

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
}
