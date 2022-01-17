<?php

namespace App\Controllers;


use App\Registry;
use App\Controller;
use App\Database\Connection;
use App\Request;
use App\Session;

class PerfilController extends Controller
{

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }

    public function index()
    {
        return view('perfil', ['nom' => 'Gestio del perfil']);
    }

    public function updatePerfil()
    {
        try {
            //recollim dades del formulari
            $newName = filter_input(INPUT_POST, 'nomUpdate');
            $newEmail = filter_input(INPUT_POST, 'emailUpdate');
            //si el que esta fent la modificacio es l'administrador, recollirem unes dades o unes altres
            if ($_SESSION["rolUser"] == "admins") {
                $userData = filter_input(INPUT_POST, 'userUpdate');
                $newCourse = filter_input(INPUT_POST, 'courseUpdate');
                //separem la informacio que ens interessa (arriba en format "id;;tipusUsuari")
                $userDataExploded = explode(';;', $userData);
                $idUser = $userDataExploded[0];
                $tipusUser = $userDataExploded[1];
            } else {
                $newPasswd = filter_input(INPUT_POST, 'passwdUpdate');
                $checkNewPasswd = filter_input(INPUT_POST, 'passwdUpdateDoubleCheck');
                //si un professor/estudiant esta fent el canvi, obtenim el tipus d'usuari i el seu mitjançant les variables de sessio
                $idUser = $_SESSION["idUser"];
                $tipusUser = $_SESSION["rolUser"];
            }

            //codi per si l'usuari vol canviar el nom
            if ($newName != "") {
                //connexio a bbdd i execucio stmt
                $qb = Registry::get('database');
                $sql = "UPDATE {$tipusUser} SET name=:name WHERE id=:idUser";
                $stmt = $qb->query($sql);
                $stmt->execute([":name" => $newName, ":idUser" => $idUser]);
            }

            //codi per si l'usuari vol canviar el email
            if ($newEmail != "") {
                //connexio a bbdd i execucio stmt
                $qb = Registry::get('database');
                $sql = "UPDATE {$tipusUser} SET email=:email WHERE id=:idUser";
                $stmt = $qb->query($sql);
                $stmt->execute([":email" => $newEmail, ":idUser" => $idUser]);
            }

            //codi per si l'usuari vol canviar la contrasenya
            if ($newPasswd != "" && $checkNewPasswd != "" && ($newPasswd == $checkNewPasswd)) {
                //connexio a bbdd i execucio stmt
                $qb = Registry::get('database');
                $sql = "UPDATE {$tipusUser} SET password=:password WHERE id=:idUser";
                $stmt = $qb->query($sql);
                $opciones = ['cost' => 4];
                $hashedPassword = password_hash($newPasswd, PASSWORD_DEFAULT, $opciones);
                $stmt->execute([":password" => $hashedPassword, ":idUser" => $idUser]);
            }

            //codi per si l'administrador vol canviar el curs d'un alumne
            if ($newCourse != "") {
                //connexio a bbdd i execucio stmt
                $qb = Registry::get('database');
                $sql = "UPDATE students SET courseId=:courseId WHERE id=:idUser";
                $stmt = $qb->query($sql);
                $stmt->execute([":courseId" => $newCourse, ":idUser" => $idUser]);
            }

            //si el que ha fet el registre es un admin, el retornem a la pagina d'administracio
            if ($_SESSION["rolUser"] == "admins") {
                $this->redirectTo('adminusers');
                die;
            }

            $this->redirectTo('perfil');
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
