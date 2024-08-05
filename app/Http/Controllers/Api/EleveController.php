<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InscriptionRequest;
use App\Mail\InscriptionMail;
use App\Models\Eleve;
use App\Models\Cursus;
use App\Models\School;
use App\Models\Annee;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EleveController extends Controller
{
    /**
     * Inscription
     */
    public function inscription(InscriptionRequest $request, string $SchoolId)
    {
        try {
            $school = School::find($SchoolId);

            $annee = Annee::where('name', $request->academic_year)->first();

            $lastMatricule = DB::table('eleves')->max('matricule');
            $matricule = $lastMatricule ? $lastMatricule + 1 : 10000001;

            // Enregistrer le logo
            $photoPath = $request->file('photo')->storeAs(
                'eleve/photo',
                'photo' . $matricule . '-' . $school->id . '.' . $request->file('photo')->extension(),
                'public'
            );

            $eleve = Eleve::create([
                'matricule' => $matricule,
                'photo' => $photoPath,
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

            $eleveC = Cursus::create([
                'annee_id' => $annee->id,
                'level' => $request->level,
                'serie' => $request->serie,
                'eleve_id' => $eleve->id,
                'school_id' => $school->id
            ]);

            $pdf = FacadePdf::loadView('fiche_inscription');
            $pdfPath = 'fiches/inscription' . $school->name . '/fiche_inscription_' . $eleve->matricule . '.pdf';

            Storage::disk('public')->put($pdfPath, $pdf->output());

            // Générer le lien de téléchargement
            $downloadLink = url($pdfPath);

            Mail::to($eleve->parent_email)->queue(new InscriptionMail($school->name, $school->email, $eleve, $eleveC, $downloadLink));

            return response()->json(['success' => true, 'message' => 'Inscription réussie !', 'eleve' => [$eleve, $eleveC]], 201);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }
}
