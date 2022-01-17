<?php

namespace App\Controllers;


use App\Registry;
use App\Controller;
use App\Database\Connection;
use App\Request;
use App\Session;

class LoginController extends Controller
{
    protected $errorAuth;

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }

    public function index()
    {
        return view('login', ['nom' => 'Login']);
    }

    public function log()
    {
        try {
            //recollim dades del formulari
            $email = filter_input(INPUT_POST, 'email');
            $password = filter_input(INPUT_POST, 'passwd');
            $recordar = filter_input(INPUT_POST, 'recorda');
            $tipusUser = filter_input(INPUT_POST, 'tipusUser');

            //si l'usuari no ha omplert algun dels camps necessaris el retornem al login
            if ($email == "" or $password == "" or $tipusUser == "") {
                $this->redirectTo('login');
            }

            //connexio a bbdd i execucio stmt
            $qb = Registry::get('database');
            $sql = "SELECT * FROM {$tipusUser} WHERE email=?;";
            $stmt = $qb->query($sql);
            $stmt->execute([$email]);
            $rows = $stmt->fetchAll();

            //check contrasenya
            $pwdOK = password_verify($password, $rows[0]['password']);

            /*si el resultat de $rows es null vol dir que l'usuari no te el rol amb el que es vol autenticar
            si !$pwdOK == true vol dir que la contrasenya es incorrecta
            en qualsevol dels casos tornem a l'usuari al login*/
            if ($rows == null or !$pwdOK) {
                $this->redirectTo('login');
            }

            if ($pwdOK) {
                //les dades de l'usuari en cookies
                setcookie("activeUser", $rows[0]["name"], time() + 60 * 60 * 24 * 30, "/");
                setcookie("emailUser", $email, time() + 60 * 60 * 24 * 90, "/");
                if (!isset($_COOKIE["recorda"]) and $recordar) {
                    setcookie("recorda", true, time() + 60 * 60 * 24 * 90, "/");
                } else  if (isset($_COOKIE["recorda"]) and !$recordar) {
                    //cas en que l'usuari ha volgut recordar les credencials pero despres decideix no tornar-les a guardar
                    setcookie("recorda", null, time() + 60 * 60 * 24 * 90, "/");
                }
                if (!isset($_SESSION["emailUser"])) {
                    $_SESSION["emailUser"] = $email;
                }
                if (!isset($_SESSION["idUser"])) {
                    $_SESSION["idUser"] = $rows[0]["id"];
                }
                if (!isset($_SESSION["rolUser"])) {
                    $_SESSION["rolUser"] = $tipusUser;
                }

                //ara comprovarem si l'usuari es un alumne i esta matriculat a un curs
                if ($tipusUser == "students" && $rows[0]["courseId"] == null) {
                    //si no ho esta l'enviarem a la vista per matricularse
                    $this->redirectTo('matricula');
                } else {
                    //si ho esta l'enviem directament al dashboard
                    $this->redirectTo('dashboard');
                }
            }
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
