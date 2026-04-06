<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Identifiants incorrects'], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response([
            'user'    => $user,
            'token'   => $token,
            'role'    => $user->role, // Très utile pour le Frontend
            'message' => 'Login réussi !'
        ], 200);
    }

    public function logout(Request $request)
    {
        // Supprime tous les tokens de l'utilisateur connecté
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Déconnecté avec succès'], 200);
    }
}