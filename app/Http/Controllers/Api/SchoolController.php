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
        if (!Session::exists('admin_connect')) {
            return response()->json(['success' => false, 'message' => "Vous n'êtes pas connecté"], 400);
        }
        try {
            // Enregistrer le logo
            $logoPath = $request->file('logo')->storeAs(
                'school/logo',
                $request->input('name') . '.' . $request->file('logo')->extension(),
                'public'
            );

            // Enregistrer l'école dans la base de données
            $school = School::create([
                'name' => $request->input('name'),
                'logo' => $logoPath,
                'email' => $request->input('email'),
                'adresse' => $request->input('adresse'),
                'phone_number' => $request->input('phone_number'),
                'password' => bcrypt($request->input('password')),
                'verify_link_send' => now(),
            ]);

            // Envoi du mail
            Mail::to($school->email)->queue(new CreateSchool($school));

            return response()->json(['success' => true, 'message' => 'École créée avec succès'], 201);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
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
