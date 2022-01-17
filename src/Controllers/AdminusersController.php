<?php

namespace App\Controllers;


use App\Registry;
use App\Controller;
use App\Database\Connection;
use App\Request;
use App\Session;

class AdminUsersController extends Controller
{

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }

    public function index()
    {
        try {
            //aqui no utilitzo la funcio selectAll() ja que enviaria tambe la contrasenya, cosa que es insegura (a part de que no la necessitem)
            $s = $this->selectStudents();
            $t = $this->selectTeachers();
            //aqui si que la utilitzo perque necessito totes les dades
            $c = (array) Registry::get('database')->selectAll('courses');
            return view('adminusers', ['nom' => 'Administració', 'alumnes' => $s, 'professors' => $t, 'cursos' => $c]);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function selectStudents()
    {
        try {
            //funcio per mostrar els estudiants
            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "SELECT courses.acronym, students.id, students.email, students.name FROM courses RIGHT JOIN students ON students.courseId = courses.id ORDER BY acronym";
            $stmt = $qb->query($sql);
            $stmt->execute();
            $students = $stmt->fetchAll();
            return $students;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function deleteUser()
    {
        //recollim dades del formulari
        $userData = filter_input(INPUT_POST, 'deleteUser');
        //separem la informacio que ens interessa (arriba en format "id;;tipusUsuari")
        $userDataExploded = explode(';;', $userData);
        $idUser = $userDataExploded[0];
        $tipusUserString = $userDataExploded[1];
        $tipusUserInt = $this->getNumUserRole($userDataExploded[1]);

        try {
            //si l'admin no ha seleccionat cap usuari a esborrar no fem res i recarreguem la pagina
            if($userData == ""){
                $this->redirectTo('adminusers');
                die;
            }

            //necessitem obtenir el id de les llistes de l'usuari per esborrar les seves tasques
            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "SELECT id FROM lists WHERE userId=:userId AND userRole=:userRole";
            $stmt = $qb->query($sql);
            $stmt->execute([":userId" => $idUser, "userRole" => $tipusUserInt]);
            $idList = $stmt->fetchAll();
            
            //esborrem la llista de la taula lists
            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "DELETE FROM lists WHERE userId=:userId AND userRole=:userRole";
            $stmt = $qb->query($sql);
            $stmt->execute([":userId" => $idUser, "userRole" => $tipusUserInt]);

            //esborrem les tasques que hi havia a la llista de l'usuari que s'ha esborrat
            //com que pot ser que l'usuari tingui mes d'una llista hem de fer un bucle
            for($i = 0; $i < count($idList); $i++){
                //connexio a bbdd i execucio stmt
                $qb = Registry::get('database');
                $sql = "DELETE FROM taskItems WHERE listId=:id";
                $stmt = $qb->query($sql);
                $stmt->execute([":id" => $idList[$i]["id"]]);
            }

            //finalment esborrem l'usuari de la taula corresponent
            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "DELETE FROM {$tipusUserString} WHERE id=:id";
            $stmt = $qb->query($sql);
            $stmt->execute([":id" => $idUser]);

            //retornem a l'usuari a la pagina anterior
            $this->redirectTo('adminusers');
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
