<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    function login()
    {
        return view('auth.login');
    }

    function authenticate(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // print_r($data);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }
        $token = $user->createToken('my-app-token')->plainTextToken;
        $data = [
            'user' => $user->toArray(),
            'token' => $token
        ];
        return response()->json(['success' => true, 'data' => $data], 200);
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