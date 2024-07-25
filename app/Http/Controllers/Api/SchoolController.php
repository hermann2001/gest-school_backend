<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolRequest;
use App\Mail\ConfirmMail;
use App\Mail\CreateSchool;
use App\Models\School;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Mail;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getSchools()
    {
        return School::where('deleted', false)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createSchool(SchoolRequest $request)
    {
        if ($request->role != 'AdminGen') {
            return response()->json(['success' => false, 'message' => "Vous n'êtes pas connecté"], 200);
        }

        try {
            // Enregistrer le logo
            $logoPath = $request->file('logo')->storeAs(
                'school/logo',
                'logo' . $request->name . '.' . $request->file('logo')->extension(),
                'public'
            );

            // Enregistrer l'école dans la base de données
            $school = School::create([
                'name' => $request->name,
                'logo' => $logoPath,
                'email' => $request->email,
                'adresse' => $request->adresse,
                'phone_number' => $request->phone_number,
                'password' => $request->password,
                'verify_link_send' => now(),
                'secondaire' => $request->secondaire,
            ]);

            // Envoi du mail
            Mail::to($school->email)->queue(new CreateSchool($school, $request->password));

            return response()->json(['success' => true, 'message' => 'École créée avec succès'], 201);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }

    /**
     * Confirmation de l'enregistrement
     */
    public function confirm(string $id)
    {
        $date = Carbon::now();

        $school = School::find($id);

        if (!$school) {
            return response()->json(['message' => 'École non trouvée'], 200);
        }

        if (!$school->verified) {
            $verifyLinkSend = Carbon::parse($school->verify_link_send);
            $differenceInSeconds = $verifyLinkSend->diffInSeconds($date);

            if ($differenceInSeconds <= 86400) {
                $school->verified = true;
                $school->save();

                return response()->json(['message' => 'École vérifiée avec succès'], 200);
            } else {
                return response()->json(['message' => 'Lien de vérification expiré'], 200);
            }
        } else {
            return response()->json(['message' => 'École déjà vérifiée ou lien de vérification non envoyé'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function resend_verified_mail(string $id, string $connect)
    {
        if ($connect != 'AdminC2C') {
            return response()->json(['success' => false, 'message' => "Vous n'êtes pas connecté"], 200);
        }

        $school = School::find($id);

        if ($school) {
            try {
                $school->verify_link_send = now();
                $school->save();

                // Envoi du mail
                Mail::to($school->email)->queue(new ConfirmMail($school->name, $school->id));

                return response()->json(['success' => true, 'message' => 'Lien renvoyé avec succès !'], 200);
            } catch (Exception $e) {
                return response()->json(['success' => false, 'message' => 'Erreur d\'envoi du mail'], 200);
            }
        } else {
            return response()->json(['success' => false, 'message' => "Cet Etablissement n'existe pas sur notre plateforme"], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteSchool(string $id, string $connect)
    {
        if ($connect != 'AdminC2C') {
            return response()->json(['success' => false, 'message' => "Vous n'êtes pas connecté"], 200);
        }

        $school = School::find($id);

        if ($school) {
            try {
                // Suppression de l'école
                $school->deleted = true;
                $school->save();

                return response()->json(['success' => true, 'message' => 'Etablissement supprimé avec succès !'], 200);
            } catch (Exception $e) {
                return response()->json(['success' => false, 'message' => 'Erreur de suppression'], 200);
            }
        } else {
            return response()->json(['success' => false, 'message' => "Cet Etablissement n'existe pas sur notre plateforme"], 200);
        }
    }
}
