<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Les identifiants ne correspondent pas à nos enregistrements.',
            ], 401);
        }
        $inscriptionId = null;

        if ($user->student) {
            $user->student->load(['inscriptions' => function ($query) {
                $query->latest();
            }]);

            $inscriptionId = $user->student->inscriptions->first()?->id;
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'inscription_id' => $inscriptionId,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie',
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'new_password'     => 'required|min:8|confirmed',
        ]);

        $user = $request->user();


        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'message' => 'Mot de passe mis à jour avec succès.',
        ]);
    }
}
