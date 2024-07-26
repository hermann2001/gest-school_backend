<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InscriptionRequest;
use App\Models\Eleve;
use App\Models\EleveClasse;
use App\Models\School;
use Exception;
use Illuminate\Support\Facades\DB;

class EleveController extends Controller
{
    /**
     * Inscription
     */
    public function inscription(InscriptionRequest $request, string $SchoolId)
    {
        try {
            $school = School::find($SchoolId);

            $lastMatricule = DB::table('eleves')->max('matricule');
            $matricule = $lastMatricule ? $lastMatricule + 1 : 10000001;

            $eleve = Eleve::create([
                'matricule' => $matricule,
                'nom' => $request->nom,
                'prenoms' => $request->prenoms,
                'birthday' => $request->birthday,
                'adresse' => $request->adresse,
                'masculin' => $request->sexe,
                'nom_prenoms_pere' => $request->name_pere,
                'nom_prenoms_mere' => $request->name_mere,
                'parent_email' => $request->parent_mail,
                'parent_telephone' => $request->parent_telephone,
            ]);

            EleveClasse::create([
                'academic_year' => $request->academic_year,
                'level' => $request->level,
                'serie' => $request->serie,
                'eleve_id' => $eleve->id,
            ]);

            return response()->json(['success' => true, 'message' => 'Inscription réussie !'], 201);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }
}
