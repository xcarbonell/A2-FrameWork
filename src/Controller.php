<?php

namespace App;

use App\Request;
use App\Session;

class Controller
{
    protected $request;
    protected $session;

    function __construct(Request $request, Session $session)
    {
        $this->request = $request;
        $this->session = $session;
    }

    function error(String $str)
    {
        Session::set('error', $str);
    }

    public function redirectTo($location)
    {
        return header('Location:' . root() . $location);
    }

    public function listSearcher()
    {
        $user = $_SESSION["idUser"];
        $tipusUser = $this->getNumUserRole($_SESSION["rolUser"]);

        try {
            //buscador de les llistes de tasques que te l'usuari
            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "SELECT id, listName FROM lists WHERE userId=:user AND userRole=:userRole;";
            $stmt = $qb->query($sql);
            $stmt->execute([":user" => $user, ":userRole" => $tipusUser]);
            $rows = $stmt->fetchAll();
            return $rows;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function taskSearcher()
    {
        $rows = $this->listSearcher();

        try {
            //comptem quantes llistes de tasques te l'usuari i ho guardem en una variable que utilitzarem mes tard
            $nLlistes = count($rows);

            //creem una variable que ens dira si a l'usuari te tasques a la llista, de primeres la posem com a false fins que no es demostri el contrari
            $hiHaTasques = false;
            $llistatTasques = null;

            if ($rows != null) {
                if ($nLlistes == 1) {
                    $llista = $rows[0];

                    //connexio a bbdd i execucio stmt
                    $qb = Registry::get('database');
                    $sql = "SELECT id, item, completed FROM taskItems WHERE listId=?;";
                    $stmt = $qb->query($sql);
                    $stmt->execute([$llista[0]]);

                    //guardem resultats de la sentencia
                    $llistatTasques[0] = $stmt->fetchAll();

                    //comprovem que la llista no estigui buida
                    if (count($llistatTasques[0]) != 0) {
                        $hiHaTasques = true;
                    }
                } else {
                    //si l'usuari te mes d'una llista, crearem un bucle per treure totes les dades
                    for ($i = 0; $i < $nLlistes; $i++) {
                        $llista = $rows[$i][0];

                        //connexio a bbdd i execucio stmt
                        $qb = Registry::get('database');
                        $sql = "SELECT id, item, completed FROM taskItems WHERE listId=?;";
                        $stmt = $qb->query($sql);
                        $stmt->execute([$llista]);

                        //guardem resultats de la sentencia
                        $llistatTasques[$i] = $stmt->fetchAll();

                        //comprovem que la llista no estigui buida
                        if (count($llistatTasques[$i]) != 0) {
                            $hiHaTasques = true;
                        }
                    }
                }
            }
            $res = [];
            $res[0] = $llistatTasques;
            $res[1] = $hiHaTasques;
            return $res;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getNumUserRole($rolString)
    {
        //funcio per saber quin es el rol de l'usuari per tal de trobar correctament la seva llista de tasques a la BBDD
        if ($rolString == "students") {
            $tipusUser = 0;
        } else if ($rolString == "teachers") {
            $tipusUser = 1;
        } else if ($rolString == "admins") {
            $tipusUser = 2;
        }
        return $tipusUser;
    }

    public function selectTeachers()
    {
        try {
            //funcio per mostrar els professors
            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "SELECT id, email, name FROM teachers ORDER BY name";
            $stmt = $qb->query($sql);
            $stmt->execute();
            $teachers = $stmt->fetchAll();
            return $teachers;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
