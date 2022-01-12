<?php

namespace App\Controllers;


use App\Registry;
use App\Controller;
use App\Database\Connection;
use App\Request;
use App\Session;

class CursController extends Controller
{

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }

    public function index()
    {
        try {
            $idUser = $_SESSION["idUser"];
            //primer obtenim el llistat de les materies que imparteix el professor
            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "SELECT name, courseId FROM subjects WHERE teacherId=:teacherId;";
            $stmt = $qb->query($sql);
            $stmt->execute([":teacherId" => $idUser]);
            $subjects = $stmt->fetchAll();

            //ara obtenim els cursos on fa classe, hem d'utilitzar un bucle ja que es possible que un professor tingui mes d'un curs
            for ($i = 0; $i < count($subjects); $i++) {
                $idCurs = $subjects[$i]["courseId"];
                //connexio a bbdd i execucio stmt
                $qb = Registry::get('database');
                $sql = "SELECT id, acronym, name FROM courses WHERE id=:id;";
                $stmt = $qb->query($sql);
                $stmt->execute([":id" => $idCurs]);
                $courses[$i] = $stmt->fetchAll();
            }

            //per acabar, obtenim els alumnes que estan matriculats als cursos que imparteix el professor
            for ($i = 0; $i < count($courses); $i++) {
                for ($j = 0; $j < count($courses[$i]); $j++) {
                    $idAlumne = $courses[$i][$j]["id"];
                    //connexio a bbdd i execucio stmt
                    $qb = Registry::get('database');
                    $sql = "SELECT email, name FROM students WHERE courseId=:courseId;";
                    $stmt = $qb->query($sql);
                    $stmt->execute([":courseId" => $idAlumne]);
                    $students[$i] = $stmt->fetchAll();
                }
            }

            return view('curs', ['nom' => 'Gestio del curs', 'materies' => $subjects, 'cursos' => $courses, 'alumnes' => $students]);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
