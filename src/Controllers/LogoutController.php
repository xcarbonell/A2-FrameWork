<?php

namespace App\Controllers;


use App\Registry;
use App\Controller;
use App\Database\Connection;
use App\Request;
use App\Session;

class LogoutController extends Controller
{

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }

    public function index()
    {
        //esborrem les cookies que existeixen i enviem l'usuari al login

        if (isset($_COOKIE["recorda"])) {
            //si l'usuari ha decidit que el recordem en el sistema no esborrarem les seves credencials de login
            $hoy = date("F j, Y, g:i a");
            setcookie("recorda", null, time() + 60 * 60 * 24 * 30, "/");
            $volTornar = true;
        } else {
            //si l'usuari ha decidit que NO el recordem en el sistema esborrarem les seves credencials de login
            if (isset($_COOKIE["emailUser"])) {
                setcookie("emailUser", null, time() + 60 * 60 * 24 * 30, "/");
            }
            if (isset($_COOKIE["activeUser"])) {
                setcookie("activeUser", null, time() + 60 * 60 * 24 * 30, "/");
            }
            $volTornar = false;
        }

        session_destroy();

        if($volTornar){
            return view('login', ['nom' => 'Login', 'data' => $hoy]);
        } else {
            return view('login', ['nom' => 'Login']);
        }
    }
}
