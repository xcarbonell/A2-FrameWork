<?php

namespace App\Controllers;


use App\Registry;
use App\Controller;
use App\Database\Connection;
use App\Request;
use App\Session;

class ListsController extends Controller
{

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }

    public function index()
    {
        $listData = $this->listSearcher();
        $taskData = $this->taskSearcher();
        if($listData == null){
            $teLlistes = false;
        } else {
            $teLlistes = true;
        }
        return view('lists', ['nom' => 'Gestio de les tasques', 'llistatTasques' => $taskData[0], 'quedenTasques' => $taskData[1], 'llistes' => $listData, 'teLlistes' => $teLlistes]);
    }

    public function createList()
    {
        //recollim dades del formulari
        $name = filter_input(INPUT_POST, 'createListName');

        //si l'usuari no ha posat el nom de la llista el retornem a la pagina anterior
        if ($name == "") {
            $this->redirectTo('lists');
            die;
        }

        try {
            $user = $_SESSION["idUser"];
            $tipusUser = $this->getNumUserRole($_SESSION["rolUser"]);

            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "INSERT INTO lists(listName,userId,userRole) VALUES(:listName,:userId,:userRole)";
            $stmt = $qb->query($sql);
            $stmt->execute([":listName" => $name, ":userId" => $user, ":userRole" => $tipusUser]);

            //retornem a l'usuari a la pagina anterior
            $this->redirectTo('lists');
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function updateList()
    {
        //recollim dades del formulari
        $idList = filter_input(INPUT_POST, 'updateList');
        $name = filter_input(INPUT_POST, 'updateListName');

        //si l'usuari no ha posat el nom nou de la llista el retornem a la pagina anterior
        if ($name == "") {
            $this->redirectTo('lists');
            die;
        }

        try {
            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "UPDATE lists SET listName=:listName WHERE id=:id";
            $stmt = $qb->query($sql);
            $stmt->execute([":listName" => $name, ":id" => $idList]);

            //retornem a l'usuari a la pagina anterior
            $this->redirectTo('lists');
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function deleteList()
    {
        //recollim dades del formulari
        $idList = filter_input(INPUT_POST, 'deleteList');

        try {
            //esborrem la llista de la taula lists
            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "DELETE FROM lists WHERE id=:id";
            $stmt = $qb->query($sql);
            $stmt->execute([":id" => $idList]);

            //esborrem les tasques que hi havia a la llista que s'ha esborrat
            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "DELETE FROM taskItems WHERE listId=:id";
            $stmt = $qb->query($sql);
            $stmt->execute([":id" => $idList]);

            //retornem a l'usuari a la pagina anterior
            $this->redirectTo('lists');
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
