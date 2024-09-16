<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Controllers\VocabularyController;

class UserController extends Controller
{
    function login()
    {
        $user = session('user');
        $token = session('token');
        if ($user && $token) {
            $vocabulariesController = new VocabularyController();
            return $vocabulariesController->index($user, $token);
        }
        return view('auth.login');
    }

    function authenticate(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return Redirect::back()->withErrors(["Aucun utilisateur n'a été trouvé pour ce nom et ce mot de passe."]);
        }
        $token = $user->createToken('my-app-token')->plainTextToken;
        session([
            'user' => $user,
            'token' => $token,
        ]);
        $vocabulariesController = new VocabularyController();
        return $vocabulariesController->index($user, $token);
    }

    function logout(Request $request)
    {
        $token = $request->input('userToken');
        if ($token) {
            $personalAccessToken = PersonalAccessToken::findToken($token);
            if ($personalAccessToken) {
                $personalAccessToken->tokenable;
                $personalAccessToken->delete();
                // Supprimer la session utilisateur
                $request->session()->flush();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return view('auth.login');
            }
        }
        return response([
            'message' => 'Invalid token or user not found'
        ], 401);
    }
}