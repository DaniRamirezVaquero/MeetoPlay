<?php

use FTP\Connection;

    require_once  $_SESSION['rootPath']."/controllers/controller.php";
    require_once  $_SESSION['rootPath']."/controllers/eventController.php";
    require_once $_SESSION['rootPath']."/models/user.php";
    require_once $_SESSION['rootPath']."/library/Anti_csrf.php";
    require_once $_SESSION['rootPath']."/library/extra_functs.php";

    class userController extends Controller {

        /**
         * Muestra el formuario de login
         * @return
         */
        public function showLogin () {

            $token = Anti_csrf::getAnti_csrf()->generateToken(); // Genero un token de seguridad

            $errCode = $_GET["errCode"] ?? null;

            $this->render("user/login.twig", ["token" => $token , "errCode" => $errCode]);
            
        }

        /**
         * Muestra el formuario de registro
         * @return
         */
        public function showRegister () {

            $token = Anti_csrf::getAnti_csrf()->generateToken(); // Genero un token de seguridad

            $errCode = $_GET["errCode"] ?? null;

            $this->render("user/register.twig", ["token" => $token, "errCode" => $errCode]);
        }

        /**
         * Elimina un user de la base de datos
         * @return
         */
        public function delete(int $id) {
            $user = User::getUserById($id);
            $user->delete();
        }


        /**
         * Registra a un usuario
         * @return
         */
        public function register () {

            // Compruebo si el token de seguridad es correcto
            if ($_POST["_csrf"] != $_SESSION["_csrf"]) {
                redireccion("register?errCode=token"); // Si no es correcto redirijo a la página de login
            }

            //Compruebo si el formulario viene vacio
            if (empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["userName"]) || empty($_POST["bornDate"])) {
                redireccion("register?errCode=voidInput"); // Si no es correcto redirijo a la página de login
            }

            // Compruebo si el email ya existe
            if (User::emailExists($_POST["email"])) {
                redireccion("register?errCode=registeredEmail"); // Si no es correcto redirijo a la página de login
            }

            // Compruebo si el nombre de usuario ya existe
            if (User::userNameExists($_POST["userName"])) {
                redireccion("register?errCode=registeredUserName"); // Si no es correcto redirijo a la página de login
            }

            // Creo un nuevo usuario
            //Antes doy formato a la fecha
            $bornDate = date_create($_POST["bornDate"]);
            $bornDate = date_format($bornDate, "Y-m-d");

            //Y encripto la contraseña
            $password = md5($_POST["password"]);
            
            $user = new User();
            $user->userName = $_POST["userName"];
            $user->email = $_POST["email"];
            $user->password = $password;
            $user->bornDate = $bornDate;
            $user->profilePic = $_SESSION['rootPath']."/img/profilePics/defaultProfilePic.jpg";
            $user->userStatus = "Active";

            // Guardo el usuario en la base de datos
            $user->save();

            // Redirijo a la página de login
            redireccion("login");

        }

        /**
         * Comprueba si un email ya existe
         * @return
         */
        public function checkEmail ($email) {
            if (User::emailExists($email)) {
                echo "true";
            } else {
                echo "false";
            }
        }

        /**
         * Comprueba si un nombre de usuario ya existe
         * @return
         */
        public function checkUserName ($userName) {
            if (User::userNameExists($userName)) {
                echo "true";
            } else {
                echo "false";
            }
        }


        /**
         * Logea a un usuario
         * @return
         */
        public function login () {

            // Compruebo si el token de seguridad es correcto
            if ($_POST["_csrf"] != $_SESSION["_csrf"]) {
                redireccion("login?errCode=token"); // Si no es correcto redirijo a la página de login
        
            }

            // Compruebo si el formulario viene vacio
            if (empty($_POST["email"]) || empty($_POST["password"])) {
                redireccion("login?errCode=voidInput"); // Redirijo a la página de login
            }

            $user = User::loginUser($_POST["email"], $_POST["password"]);

            if (!is_null($user)) {
                $_SESSION["user"] = serialize($user); // Guarda el user en la sesión
                $_SESSION["loginTime"] = time(); // Guarda el tiempo de inicio de sesión
                redireccion("main");
            } else {
                redireccion("login?errCode=userNotFound"); // Redirijo a la página de login 
            }
        }

        /**
         * Cierra la sesión del user
         * @return
         */
        public function logout () {
            session_destroy();
            redireccion("login");
        }

        /**
         * Une un usuario a un evento
         * @return
         */
        public function joinEvent () {
            $user = unserialize($_SESSION["user"]);

            User_Join_Event::joinEvent($user->userId, $_GET["eventId"]);
            redireccion("/MeetoPlay/main");
        }

        /**
         * Saca a un usuario de un evento
         * @return
         */
        public function unjoinEvent () {
            $user = unserialize($_SESSION["user"]);

            User_Join_Event::unJoinEvent($user->userId, $_GET["eventId"]);
            redireccion("/MeetoPlay/main");
    }
}