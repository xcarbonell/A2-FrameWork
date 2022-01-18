<?php

namespace App\Controllers;


use App\Registry;
use App\Controller;
use App\Database\Connection;
use App\Request;
use App\Session;

class TasksController extends Controller
{

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }

    public function index()
    {
        $listData = $this->listSearcher();
        $taskData = $this->taskSearcher();
        return view('tasks', ['nom' => 'Gestio de les tasques', 'llistatTasques' => $taskData[0], 'quedenTasques' => $taskData[1], 'llistes' => $listData]);
    }

    public function createTask()
    {
        //recollim dades del formulari
        $name = filter_input(INPUT_POST, 'item');
        $llista = filter_input(INPUT_POST, 'llistes');
        $acabada = filter_input(INPUT_POST, 'completedCreate');

        //si l'usuari no ha posat el nom de la tasca el retornem a la pagina anterior
        if ($name == "") {
            $this->redirectTo('tasks');
            die;
        }

        try {
            //passem el valor del checkbox a 1 o 0 segons si esta acabada o no
            if (!$acabada) {
                //si no esta marcada, el seu valor es null, per tant significa que no esta acabada
                $bAcabada = 0;
            } else {
                $bAcabada = 1;
            }
            //obtenim la data d'avui per acabar d'omplir els camps
            $hoy = date("Y-m-d H:i:s");

            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "INSERT INTO taskItems(item,listId,completed,create_time,update_time) VALUES(:item,:listId,:completed,:create_time,:update_time)";
            $stmt = $qb->query($sql);
            $stmt->execute([":item" => $name, ":listId" => $llista, ":completed" => $bAcabada, ":create_time" => $hoy, ":update_time" => $hoy]);

            //retornem a l'usuari a la pagina anterior
            $this->redirectTo('tasks');
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function updateTask()
    {
        //recollim dades del formulari
        $idTasca = filter_input(INPUT_POST, 'updateTaskList');
        $nouEstat = filter_input(INPUT_POST, 'completedUpdate');

        //si l'usuari no ha posat el nou estat de la tasca el retornem a la pagina anterior
        if ($nouEstat == null) {
            $this->redirectTo('tasks');
            die;
        }

        try {
            //obtenim la data d'avui per acabar d'omplir els camps
            $hoy = date("Y-m-d H:i:s");

            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "UPDATE taskItems SET completed=:completed, update_time=:update_time WHERE id=:id";
            $stmt = $qb->query($sql);
            $stmt->execute([":completed" => $nouEstat, ":update_time" => $hoy, ":id" => $idTasca]);

            //retornem a l'usuari a la pagina anterior
            $this->redirectTo('tasks');
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function deleteTask()
    {
        //recollim dades del formulari
        $idTask = filter_input(INPUT_POST, 'deleteTaskList');

        try {
            //esborrem la tasca de la taula taskItems
            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "DELETE FROM taskItems WHERE id=:id";
            $stmt = $qb->query($sql);
            $stmt->execute([":id" => $idTask]);

            //retornem a l'usuari a la pagina anterior
            $this->redirectTo('tasks');
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
