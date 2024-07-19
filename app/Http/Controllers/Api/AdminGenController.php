<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AdminGenController extends Controller
{
    /**
     * Connexion admin général
     */
    public function connect(string $connect)
    {
        if (!Session::exists('admin_connect')) {
            if ($connect == "AdminC2C") {
                Session::put('admin_connect', "Oui");
                return response()->json(['message' => 'Connexion réussie'], 200);
            }
            return response()->json(['message' => 'Connexion échouée'], 400);
        }
        return response()->json(['message' => 'Déjà connectée'], 400);
    }

    /**
     * Déconnexion
     */
    public function disconnect()
    {
        if (Session::exists('admin_connect')) {
            Session::forget('admin_connect');
            return response()->json(['message' => 'Déconnexion réussie'], 200);
        }
        return response()->json(['message' => 'Aucune session active'], 400);
    }
}
