<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    /**
     * Affiche la liste des phrases.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user, $token)
    {
        $vocabularies = Vocabulary::all(); // Récupère toutes les phrases
        return view('home', compact('vocabularies'))
            ->with("data", ["user" => $user, "token" => $token]); // user and token are used after for performing CUD from the view
    }

    public function update(Request $request)
    {
        // Validation des données de la requête
        $request->validate([
            'id' => 'required|integer',
            'french' => 'nullable|string',
            'serere' => 'nullable|string',
            'correctly_translated' => 'nullable|numeric',
            'correctly_understood' => 'nullable|numeric',
        ]);

        // Recherche du vocabulaire à partir de l'ID
        $vocabulary = Vocabulary::find($request->id);
        if ($vocabulary) {
            // Mise à jour des champs si présents dans la requête
            if ($request->has('serere')) {
                $vocabulary->serere = $request->serere;
                if ($request->correctly_understood < 0) {
                    $vocabulary->correctly_understood = 0;
                } else {
                    $vocabulary->correctly_understood = $request->correctly_understood;
                }
            }
            if ($request->has('french')) {
                $vocabulary->french = $request->french;
                if ($request->correctly_understood < 0) {
                    $vocabulary->correctly_translated = 0;
                } else {
                    $vocabulary->correctly_translated = $request->correctly_translated;
                }
            }
            $vocabulary->save();
            return response()->json(['success' => true, 'message' => 'Update successful']);
        }
        return response()->json(['success' => false, 'message' => 'No element found'], 404);
    }

    /**
     * Supprime une phrase spécifique de la base de données.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $voc = Vocabulary::find($request->id); // Trouve la phrase par ID ou renvoie une erreur 404
        if ($voc) {
            $voc->delete();
            return response()->json(['success' => true, 'message' => 'Deletion successful']);
        }
        return response()->json(['success' => false, 'message' => 'No element found'], 404);
    }


    /**
     * Enregistre une nouvelle phrase dans la base de données.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'is_sentence' => 'nullable|boolean',
            'french' => 'required|string',
            'serere' => 'required|string',
            'correctly_translated' => 'nullable|boolean',
            'correctly_understood' => 'nullable|boolean',
        ]);

        $vocabulary = Vocabulary::create($validatedData);
        return response()->json(['success' => true, 'id' => $vocabulary->id, 'message' => 'Deletion successful']);
    }

    public function redirectToVocabulariesList(Request $request)
    {
        $token = $request->bearerToken();
        return redirect('/')->header('Authorization', 'Bearer ' . $token);
    }
}