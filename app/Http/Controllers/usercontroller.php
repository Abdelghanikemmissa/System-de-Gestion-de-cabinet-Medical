<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class usercontroller extends Controller
{
    public function createuser(Request $request)
    {
        // On respecte les colonnes de ton modèle User
        $user = User::create([
            'cni'      => $request->cni,
            'nom'      => $request->nom,
            'prenom'   => $request->prenom,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'patient', // 'patient' par défaut
        ]);

        return response()->json($user, 201);
    }
}