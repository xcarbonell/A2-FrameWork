<?php

namespace App\Controllers;


use App\Registry;
use App\Controller;
use App\Database\Connection;
use App\Request;
use App\Session;

class DashboardController extends Controller
{

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }

    public function index()
    {
        $data = $this->taskSearcher();
        $userRole = $this->getNumUserRole($_SESSION["rolUser"]);
        //enviem les dades de les tasques per realitzar
        return view('dashboard', ['llistatTasques' => $data[0], 'nom' => 'Dashboard', 'quedenTasques' => $data[1], 'userRole' => $userRole]);
    }
}
