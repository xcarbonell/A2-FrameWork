<?php

namespace App\Controllers;


use App\Registry;
use App\Controller;
use App\Database\Connection;
use App\Request;
use App\Session;

class RegisterController extends Controller
{

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }

    public function index()
    {
        return view('register', ['nom' => 'Registre']);
    }

    public function reg()
    {
        try {
            //recollim dades del formulari
            $email = filter_input(INPUT_POST, 'regEmail');
            $password = filter_input(INPUT_POST, 'regPasswd');
            $passwordCheck = filter_input(INPUT_POST, 'regPasswdCheck');
            $nom = filter_input(INPUT_POST, 'regNom');
            $tipusUser = filter_input(INPUT_POST, 'regRol');

            //si l'usuari no ha omplert algun dels camps necessaris el retornem al login
            if ($email == "" or $password == "" or $passwordCheck == "" or $nom == "" or $tipusUser == "") {
                $this->redirectTo('/register');
            }
            //si les contrasenyes no coincideixen, el registre haura estat incorrecte
            if ($password != $passwordCheck) {
                $this->redirectTo('/register');
            }
            //si passa les condicions anteriors, procedim a afegir el nou usuari a la taula corresponent
            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            if ($tipusUser == "student") {
                $sql = "INSERT INTO students(email,password,name) VALUES(:email,:password,:name)";
            }
            if ($tipusUser == "teacher") {
                $sql = "INSERT INTO teachers(email,password,name) VALUES(:email,:password,:name)";
            }
            $stmt = $qb->query($sql);
            $opciones = ['cost' => 4];
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT, $opciones);
            //deixem que el courseId sigui null i que l'usuari es registri a un curs un cop inicii sessio
            $stmt->execute([":email" => $email, ":password" => $hashedPassword, ":name" => $nom]);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }

        //si el que ha fet el registre es un admin, el retornem a la pagina d'administracio
        if ($_SESSION["rolUser"] == "admins") {
            $this->redirectTo('/adminusers');
            die;
        }

        $this->redirectTo('/login');
    }
}
