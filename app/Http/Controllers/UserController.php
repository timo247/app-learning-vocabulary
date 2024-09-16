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
        return view('auth.login');
    }

    function authenticate(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return Redirect::back()->withErrors(["Aucun utilisateur n'a été trouvé pour ce nom et ce mot de passe."]);
        }
        $token = $user->createToken('my-app-token')->plainTextToken;
        $vocabulariesController = new VocabularyController();
        return $vocabulariesController->index($user, $token);
    }

    function logout(Request $request)
    {
        $token = $request->bearerToken();
        if ($token) {
            $personalAccessToken = PersonalAccessToken::findToken($token);
            if ($personalAccessToken) {
                $user = $personalAccessToken->tokenable;
                $personalAccessToken->delete();
                return response([
                    'message' => 'Logged out successfully'
                ], 200);
            }
        }
        return response([
            'message' => 'Invalid token or user not found'
        ], 401);
    }
}