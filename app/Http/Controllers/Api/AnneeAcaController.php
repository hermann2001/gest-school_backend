<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnneeRequest;
use App\Models\Annee;
use DateTime;
use Exception;

class AnneeAcaController extends Controller
{
    /**
     * Récupérer une année
     */
    public function getCurrentYear()
    {
        try {
            $aca_year = Annee::were('current', true)->first();

            if ($aca_year) {
                return response()->json(['success' => true, 'yearA' => $aca_year], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }

    /**
     * Création d'une nouvelle année académique
     */
    public function createYear(AnneeRequest $request)
    {
        if ($request->role != 'AdminGen') {
            return response()->json(['success' => false, 'message' => "Vous n'êtes pas connecté"], 200);
        }

        try {
            $date_debut = new DateTime($request->date_debut);
            $date_fin = new DateTime($request->date_fin);
            $name = $date_debut->format('Y') . '-' . $date_fin->format('Y');


            $lastY = Annee::were('current', true)->first();
            if ($lastY) {
                $lastY->current = false;
                $lastY->save();
            }

            $newY = Annee::create([
                'name' => $name,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin
            ]);

            return response()->json(['success' => true, 'message' => 'Nouvelle année académique ' . $newY->name], 201);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }

    /**
     * Récupérer toutes les années académiques existante
     */
    public function getAllYear()
    {
        return Annee::all();
    }
}
