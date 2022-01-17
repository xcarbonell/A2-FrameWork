<?php

namespace App\Controllers;


use App\Registry;
use App\Controller;
use App\Database\Connection;
use App\Request;
use App\Session;

class AdminsubjectsController extends Controller
{

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }

    public function index()
    {
        try {
            $teachers = $this->selectTeachers();
            $subjects = $this->selectSubjects();
            $courses = Registry::get('database')->selectAll('courses');
            return view('adminsubjects', ['nom' => "Administració d'assignatures", 'assignatures' => $subjects, 'professors' => $teachers, 'cursos' => $courses]);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function selectSubjects()
    {
        try {
            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "SELECT subjects.id, subjects.name, teachers.name as profe, courses.acronym as siglas FROM subjects RIGHT JOIN teachers ON subjects.teacherId = teachers.id RIGHT JOIN courses ON subjects.courseId = courses.id ORDER BY acronym";
            $stmt = $qb->query($sql);
            $stmt->execute();
            $subjects = $stmt->fetchAll();
            return $subjects;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function addSubject()
    {
        try {
            $name = filter_input(INPUT_POST, 'addSubjectName');
            $teacher = filter_input(INPUT_POST, 'addSubjectTeacher');
            $course = filter_input(INPUT_POST, 'addSubjectCourse');

            //si l'admin no omple tots els camps recarreguem la pagina
            if ($name == "" or $teacher == "" or $course == "") {
                $this->redirectTo('adminsubjects');
                die;
            }

            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "INSERT INTO subjects(name, teacherId, courseId) VALUES(:name, :teacherId, :courseId)";
            $stmt = $qb->query($sql);
            $stmt->execute([":name" => $name, ":teacherId" => $teacher, ":courseId" => $course]);

            $this->redirectTo('adminsubjects');
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function updateSubject()
    {
        //recollim les dades del formulari
        $subjectId = filter_input(INPUT_POST, 'updateSubjectId');
        $newTeacher = filter_input(INPUT_POST, 'updateSubjectTeacher');
        $newCourse = filter_input(INPUT_POST, 'updateSubjectCourse');
        $newName = filter_input(INPUT_POST, 'updateSubjectName');

        //si l'admin no ha seleccionat cap assignatura per modificar recarreguem la pagina
        if ($subjectId == "") {
            $this->redirectTo('adminsubjects');
            die;
        }

        try {
            //codi per si l'admin vol canviar el professor
            if ($newTeacher != "") {
                //connexio a bbdd i execucio stmt
                $qb = Registry::get('database');
                $sql = "UPDATE subjects SET teacherId=:teacherId WHERE id=:subjectId";
                $stmt = $qb->query($sql);
                $stmt->execute([":teacherId" => $newTeacher, ":subjectId" => $subjectId]);
            }

            //codi per si l'admin vol canviar el curs
            if ($newCourse != "") {
                //connexio a bbdd i execucio stmt
                $qb = Registry::get('database');
                $sql = "UPDATE subjects SET courseId=:courseId WHERE id=:subjectId";
                $stmt = $qb->query($sql);
                $stmt->execute([":courseId" => $newCourse, ":subjectId" => $subjectId]);
            }

            //codi per si l'admin vol canviar el nom
            if ($newName != "") {
                //connexio a bbdd i execucio stmt
                $qb = Registry::get('database');
                $sql = "UPDATE subjects SET name=:name WHERE id=:subjectId";
                $stmt = $qb->query($sql);
                $stmt->execute([":name" => $newName, ":subjectId" => $subjectId]);
            }

            $this->redirectTo('adminsubjects');
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function deleteSubject(){
        try {
            $subjectId = filter_input(INPUT_POST, 'deleteSubjectId');

            //si l'admin no ha seleccionat l'assignatura que vol esborrar recarreguem la pagina
            if ($subjectId == "") {
                $this->redirectTo('adminsubjects');
                die;
            }

            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "DELETE FROM subjects WHERE id=:id";
            $stmt = $qb->query($sql);
            $stmt->execute([":id" => $subjectId]);

            $this->redirectTo('adminsubjects');
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
