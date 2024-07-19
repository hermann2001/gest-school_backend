<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminGenController extends Controller
{
    /**
     * Connexion admin général
     */
    public function connect(string $connect)
    {
        if (!Session::exists('admin_connect') && $connect == "AdminC2C") {
            Session::put('admin_connect', "Oui");
        }
    }

    /**
     * Déconnexion
     */
    public function disconnect()
    {
        if (!Session::exists('admin_connect')) {
            Session::forget('admin_connect');
        }
    }
}
