<?php

namespace App\Controllers;


use App\Registry;
use App\Controller;
use App\Database\Connection;
use App\Request;
use App\Session;

class AdmincoursesController extends Controller
{

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }

    public function index()
    {
        try {
            $c = (array) Registry::get('database')->selectAll('courses');
            return view('admincourses', ['nom' => 'Administració dels cursos', 'cursos' => $c]);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function addCourse()
    {
        $name = filter_input(INPUT_POST, 'addCourseName');
        $acronym = filter_input(INPUT_POST, 'addCourseAcronym');

        try {
            //si l'admin no ha omplert algun dels camps recarreguem la pagina
            if ($name == "" or $acronym == "") {
                $this->redirectTo('admincourses');
                die;
            }

            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "INSERT INTO courses(acronym, name) VALUES(:acronym,:name)";
            $stmt = $qb->query($sql);
            $stmt->execute([":acronym" => $acronym, ":name" => $name]);

            $this->redirectTo('admincourses');
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function updateCourse()
    {
        try {
            $courseId = filter_input(INPUT_POST, 'updateCourseId');
            $newName = filter_input(INPUT_POST, 'updateCourseName');
            $newAcronym = filter_input(INPUT_POST, 'updateCourseAcronym');

            //si l'admin no ha seleccionat el curs que vol modificar recarreguem la pagina
            if ($courseId == "") {
                $this->redirectTo('admincourses');
                die;
            }

            //codi per si l'admin vol canviar el nom
            if ($newName != "") {
                //connexio a bbdd i execucio stmt
                $qb = Registry::get('database');
                $sql = "UPDATE courses SET name=:name WHERE id=:courseId";
                $stmt = $qb->query($sql);
                $stmt->execute([":name" => $newName, ":courseId" => $courseId]);
            }

            //codi per si l'admin vol canviar les sigles
            if ($newAcronym != "") {
                //connexio a bbdd i execucio stmt
                $qb = Registry::get('database');
                $sql = "UPDATE courses SET acronym=:acronym WHERE id=:courseId";
                $stmt = $qb->query($sql);
                $stmt->execute([":acronym" => $newAcronym, ":courseId" => $courseId]);
            }

            $this->redirectTo('admincourses');
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function deleteCourse()
    {
        try {
            $courseId = filter_input(INPUT_POST, 'deleteCourseId');

            //si l'admin no ha seleccionat el curs que vol esborrar recarreguem la pagina
            if ($courseId == "") {
                $this->redirectTo('admincourses');
                die;
            }

            //primer haurem d'esborrar les assignatures que formen part del curs que eliminarem
            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "DELETE FROM subjects WHERE courseId=:id";
            $stmt = $qb->query($sql);
            $stmt->execute([":id" => $courseId]);

            //finalment esborrem el curs
            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "DELETE FROM courses WHERE id=:id";
            $stmt = $qb->query($sql);
            $stmt->execute([":id" => $courseId]);

            $this->redirectTo('admincourses');
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
