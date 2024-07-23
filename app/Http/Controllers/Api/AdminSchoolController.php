<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminSchoolConnect;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminSchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function connect(AdminSchoolConnect $request)
    {
        $school = School::where('email', $request->input('email'))->first();

        if ($school && Hash::check($request->input('password'), $school->password) && !$school->deleted) {
            if ($school->verified) {
                $school->role = 'AdminSch';
                return response()->json(['success' => true, 'school' => $school], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Veuillez vérifier l\'enregistrement de votre établissement pour vous connecter !', 'school' => $school], 200);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Email ou mot de passe incorrect !', 'school' => $school], 200);
        }
    }
}
