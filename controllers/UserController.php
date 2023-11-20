<?php

    require_once "Controller.php";
    require_once "models/User.php";
    require_once "library/Anti_csrf.php";
    require_once "library/extra_functs.php";

    class userController extends Controller {

        /**
         * Muestra el formuario de login
         * @return
         */
        public function showLogin () {

            $token = Anti_csrf::getAnti_csrf()->generateToken(); // Genero un token de seguridad

            $this->render("user/login.twig", ["token" => $token]);
            
        }

        /**
         * Elimina un user de la base de datos
         * @return
         */
        public function delete(int $id) {
            $user = User::getUserById($id);
            $user->delete();
        }

        public function login () {

            // Compruebo si el token de seguridad es correcto
            if ($_POST["_csrf"] != $_SESSION["_csrf"]) {
                echo "<script>alert('Error: Los tokens de seguridad no coinciden. Por favor, recarga la página e intenta de nuevo.');</script>";

                redireccion("http://localhost/login"); // Si no es correcto redirijo a la página de login

                
            }

            // Compruebo si el formulario viene vacio
            if (empty($_POST["email"]) || empty($_POST["password"])) {
                echo "<script>alert('Error: Porfavor, rellene todos los campos e intentelo de nuevo');</script>";

                //TODO: Corregir problema de redirección
                redireccion("login"); // Redirijo a la página de login
            }

            $user = User::loginUser($_POST["email"], $_POST["password"]);

            if (!is_null($user)) {
                $_SESSION["user"] = serialize($user); // Guarda el user en la sesión
                $_SESSION["loginTime"] = time(); // Guarda el tiempo de inicio de sesión
                redireccion("main");
            } else {
                //TODO: Corregir problema de redirección
                echo "<script>alert('Error: No se ha encontrado el user');</script>";
                redireccion("login"); // Redirijo a la página de login 
            }

            // // Inicio la sesión
            // session_start();
            // $_SESSION["user"] = $user;

            // // Redirijo a la página de inicio
            // header("Location: index.php");
        }

        /**
         * Cierra la sesión del user
         * @return
         */
        public function logout () {
            session_destroy();
            redireccion("login");
        }
    }