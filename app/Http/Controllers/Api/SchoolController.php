<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolRequest;
use App\Mail\CreateSchool;
use App\Models\School;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getSchools()
    {
        return School::all();
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
    public function confirm(string $name_hash)
    {
        $date = Carbon::now();

        $schools = School::all();

        $school = null;

        foreach ($schools as $sch) {
            if (Hash::check($sch->name, $name_hash)) {
                $school = $sch;
                break;
            }
        }

        if (!$school) {
            return response()->json(['message' => 'École non trouvée'], 404);
        }

        if (!$school->verified) {
            $verifyLinkSend = Carbon::parse($school->verify_link_send);
            $differenceInDays = $verifyLinkSend->diffInDays($date);

            if ($differenceInDays <= 1) {
                $school->verified = true;
                $school->save();

                return redirect(env('URL_FRONTEND'), 200);
            } else {
                return redirect(env('URL_FRONTEND'));
            }
        } else {
            return response()->json(['message' => 'École déjà vérifiée ou lien de vérification non envoyé'], 400);
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
