<?php

namespace App\Controllers;


use App\Registry;
use App\Controller;
use App\Database\Connection;
use App\Request;
use App\Session;

class ResetController extends Controller
{

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }

    public function index()
    {
        //esborrem les dades del login anterior
        if (isset($_COOKIE["emailUser"])) {
            setcookie("emailUser", null, time() + 60 * 60 * 24 * 30, "/");
        }
        if (isset($_COOKIE["activeUser"])) {
            setcookie("activeUser", null, time() + 60 * 60 * 24 * 30, "/");
        }
        if (isset($_COOKIE["recorda"])) {
            setcookie("recorda", null, time() + 60 * 60 * 24 * 30, "/");
        }
        if (isset($_COOKIE["ultimaConex"])) {
            setcookie("ultimaConex", null, time() + 60 * 60 * 24 * 30, "/");
        }

        return view('login', ['nom' => 'Login']);
    }
}
