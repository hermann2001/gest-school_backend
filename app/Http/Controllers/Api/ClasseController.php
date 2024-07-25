<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClasseRequest;
use App\Models\Classe;
use App\Models\School;
use Exception;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getClass(string $schoolId)
    {
        return Classe::where('school_id', $schoolId)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addClass(ClasseRequest $request, string $id)
    {
        if ($request->role != 'AdminSh') {
            return response()->json(['success' => false, 'message' => "Vous n'êtes pas connecté"], 200);
        }

        try {
            $school = School::find($id);

            Classe::create([
                'name' => $request->name,
                'level' => $request->level,
                'effectif' => $request->effectif,
                'school_id' => $school->id
            ]);

            return response()->json(['success' => true, 'message' => 'Classe créée avec succès !'], 201);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur de création de la classe !'], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
