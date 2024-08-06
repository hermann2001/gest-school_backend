<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InscriptionRequest;
use App\Http\Requests\ReinscriptionRequest;
use App\Mail\InscriptionMail;
use App\Mail\ReinscriptionMail;
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

    public function getStudent(string $matricule)
    {
        $aca_actu_year = Annee::where('current', true)->first();

        $eleve = Eleve::where('matricule', $matricule)->first();
        if ($eleve) {
            $eleveC = Cursus::where('eleve_id', $eleve->id)->orderBy('created_at', 'desc')->first();
            if ($eleveC) {
                $aca_year = Annee::find($eleveC->annee_id);
                if ($eleveC->resultat != "En attente" && $aca_actu_year->name != $aca_year->name) {
                    return response()->json(['success' => true, 'eleve' => [$eleve, $eleveC]], 200);
                } else {
                    return response()->json(['success' => false, 'message' => "Impossible de réinscrire ! Résultat encore en attente ou année non terminée"], 200);
                }
            }
        }
        return response()->json(['success' => false, 'message' => "Aucun élève avec ce matricule !"], 200);
    }

    public function reinscription(ReinscriptionRequest $request)
    {
        try {
            $eleve = Eleve::where('matricule', $request->input('matricule'))->first();

            $eleveC = Cursus::where('eleve_id', $eleve->id)->first();

            if ($request->file('photo')) {
                $photoPath = 'eleve/photo/photo' . $request->input('matricule') . '-' . $eleveC->school_id . '.' . $request->file('photo')->extension();

                // Vérifiez si un fichier avec le même nom existe déjà
                if (Storage::disk('public')->exists($photoPath)) {
                    // Supprimez l'ancien fichier
                    Storage::disk('public')->delete($photoPath);
                }

                $newPhotoPath = $request->file('photo')->storeAs(
                    'eleve/photo',
                    'photo' . $request->input('matricule') . '-' . $eleveC->school_id . '.' . $request->file('photo')->extension(),
                    'public'
                );

                $eleve->photo = $newPhotoPath;
            }

            $eleve->adresse = $request->input('adresse');
            $eleve->parent_email = $request->input('parent_mail');
            $eleve->parent_telephone = $request->input('parent_telephone');
            $eleve->save();

            $annee = Annee::where('name', $request->input('academic_year'))->first();

            $newEleveC = Cursus::create([
                'annee_id' => $annee->id,
                'level' => $request->input('level'),
                'serie' => $request->input('serie'),
                'eleve_id' => $eleve->id,
                'school_id' => $eleveC->school_id
            ]);

            $school = School::find($newEleveC->school_id);

            $pdf = FacadePdf::loadView('fiche_reinscription');
            $pdfPath = 'fiches/reinscription' . $school->name . '/fiche_reinscription_' . $eleve->matricule . $newEleveC->level . '.pdf';

            Storage::disk('public')->put($pdfPath, $pdf->output());

            // Générer le lien de téléchargement
            $downloadLink = url($pdfPath);

            Mail::to($eleve->parent_email)->queue(new ReinscriptionMail($school->name, $school->email, $eleve, $newEleveC, $downloadLink));

            return response()->json(['success' => true, 'message' => 'Réinscription réussie !', 'eleve' => [$eleve, $eleveC]], 201);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }
}
