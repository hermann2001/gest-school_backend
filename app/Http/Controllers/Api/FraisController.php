<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FraisRequest;
use App\Models\Frais;
use App\Models\School;
use Exception;

class FraisController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function create(FraisRequest $request, string $id)
    {
        if ($request->role != 'AdminSch') {
            return response()->json(['success' => false, 'message' => "Vous n'êtes pas connecté"], 200);
        }

        try {
            $school = School::find($id);

            Frais::create([
                'level' => $request->level,
                'frais_inscription' => $request->frais_inscription,
                'frais_reinscription' => $request->frais_reinscription,
                'frais_scolarite' => $request->frais_scolarite,
                'frais_scolarite_tranche1' => $request->frais_scolarite_tranche1,
                'frais_scolarite_tranche2' => $request->frais_scolarite_tranche2,
                'frais_scolarite_tranche3' => $request->frais_scolarite_tranche3,
                'school_id' => $school->id
            ]);

            return response()->json(['success' => true, 'message' => 'Frais ajoutés avec succès !'], 201);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur d\'ajout des frais !'], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function getFrais(string $level, string $id)
    {
        try {
            $frais = Frais::where('level', $level)->where('school_id', $id)->first();

            if ($frais) {
                return response()->json(['success' => true, 'yearFrais' => $frais], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FraisRequest $request)
    {
        if ($request->role != 'AdminSch') {
            return response()->json(['success' => false, 'message' => "Vous n'êtes pas connecté"], 200);
        }

        try {
            $school = Frais::where('level', $request->level)->first();

            $school->frais_inscription = $request->frais_inscription;
            $school->frais_reinscription = $request->frais_reinscription;
            $school->frais_scolarite = $request->frais_scolarite;
            $school->frais_scolarite_tranche1 = $request->frais_scolarite_tranche1;
            $school->frais_scolarite_tranche2 = $request->frais_scolarite_tranche2;
            $school->frais_scolarite_tranche3 = $request->frais_scolarite_tranche3;
            $school->save();

            return response()->json(['success' => true, 'message' => 'Frais modifiés avec succès !'], 201);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur de modification des frais !'], 200);
        }
    }
}
