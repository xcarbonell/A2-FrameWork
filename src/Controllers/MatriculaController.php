<?php

namespace App\Controllers;


use App\Registry;
use App\Controller;
use App\Database\Connection;
use App\Request;
use App\Session;

class MatriculaController extends Controller
{

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }

    public function index()
    {
        try {
            //mostrem a l'usuari tots els cursos que te disponibles
            $c = Registry::get('database')->selectAll('courses');
            //retornem les dades de tots els cursos que hi ha perque l'usuari pugui escollir
            return view('matricula', ['nom' => 'Matricula', 'cursos' => $c]);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function inscripcio()
    {
        //recollim les dades del formulari
        $idCurs = filter_input(INPUT_POST, 'llistaCursos');
        $idUser = $_SESSION["idUser"];
        try {
            //inscribi a l'usuari al curs que ha demanat
            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "UPDATE students SET courseId=:idCurs WHERE id=:idUser";
            $stmt = $qb->query($sql);
            $stmt->execute([":idCurs" => $idCurs, ":idUser" => $idUser]);
            //enviem a l'usuari al dashboard
            $this->redirectTo('dashboard');
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
