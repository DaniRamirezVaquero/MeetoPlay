<?php

require_once  $_SESSION['rootPath'] . "/controllers/controller.php";
require_once  $_SESSION['rootPath'] . "/controllers/eventController.php";
require_once  $_SESSION['rootPath'] . "/controllers/mainController.php";
require_once $_SESSION['rootPath'] . "/models/user.php";
require_once $_SESSION['rootPath'] . "/library/Anti_csrf.php";
require_once $_SESSION['rootPath'] . "/library/extra_functs.php";

class userController extends Controller
{

  /**
   * Muestra el formuario de login
   * @return
   */
  public function showLogin()
  {

    checkSession(); // Compruebo si el usuario ya ha iniciado sesión

    $token = Anti_csrf::getAnti_csrf()->generateToken(); // Genero un token de seguridad

    // Cogemos el código de error si lo hay
    $errCode = $_GET["errCode"] ?? null;

    // Renderizo la vista enviando el token de seguridad que posteriormente se validará
    $this->render("user/login.twig", ["token" => $token, "errCode" => $errCode]);
  }

  /**
   * Muestra el formuario de registro
   * @return
   */
  public function showRegister()
  {

    checkSession(); // Compruebo si el usuario ya ha iniciado sesión

    $token = Anti_csrf::getAnti_csrf()->generateToken(); // Genero un token de seguridad

    // Cogemos el código de error si lo hay
    $errCode = $_GET["errCode"] ?? null;

    // Renderizo la vista enviando el token de seguridad que posteriormente se validará
    $this->render("user/register.twig", ["token" => $token, "errCode" => $errCode]);
  }

  /**
   * Muestra la configuración 
   * @return
   */
  public function showConfig()
  {
    checkAccess(); // Compruebo que no se está intentando acceder de manera ilegal

    // Cargamos la información necesaria para el template base
    $baseTemplateData = mainController::prepareBaseTemplateData();

    // Renderizo la vista
    $this->render("user/config.twig", ["baseTemplateData" => $baseTemplateData]);
  }

  /**
   * Muestra el perfil de un usuario
   * @return
   */
  public function showUserProfile()
  {
    checkAccess(); // Compruebo que no se está intentando acceder de manera ilegal

    // Antes de mostrar el perfil compruebo que el usuario que intenta acceder es el mismo que el que está logeado
    $logedUserId = unserialize($_SESSION["user"])->userId;
    if ($_GET["userId"] == $logedUserId) {
      $baseTemplateData = mainController::prepareBaseTemplateData();

      $userEvents = eventController::getAllEventsByOwnerId($_GET["userId"]);
      $user = User::getUserById($_GET["userId"]);

      $userRelations = userController::getUserRelations($user->userId);

      $this->render("user/profile.twig", ["baseTemplateData" => $baseTemplateData, "userEvents" => $userEvents, "user" => $user, "userRelations" => $userRelations]);
    } else { // Si no es el mismo usuario redirijo a la página de inicio
      redireccion("javascript://history.go(-1)");
    }
  }

  /** 
   * Prepara en un array la información de las relaciones de un usuario
   * @param int $userId
   * @return array
   */
  public function getUserRelations(int $userId): array
  {
    $userRelations = [];

    // Almaceno en un array la información de las relaciones del usuario de manera asociativa
    $userRelations["followedCount"] = userController::getFollowedCount($userId);
    $userRelations["followersCount"] = userController::getFollowersCount($userId);
    $userRelations["friendsCount"] = userController::getFriendsCount($userId);

    return $userRelations;
  }

  /**
   * Registra a un usuario
   * @return
   */
  public function register()
  {

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
    // Antes doy formato a la fecha
    $bornDate = date_create($_POST["bornDate"]);
    $bornDate = date_format($bornDate, "Y-m-d");

    // Y encripto la contraseña
    $password = md5($_POST["password"]);

    // Creo el usuario y le asigno los valores
    $user = new User();
    $user->userName = $_POST["userName"];
    $user->email = $_POST["email"];
    $user->password = $password;
    $user->bornDate = $bornDate;
    $user->profilePic = "/img/profilePics/defaultProfilePic.jpg";
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
  public function checkEmail($email)
  {
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
  public function checkUserName($userName)
  {
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
  public function login()
  {

    // Compruebo si el token de seguridad es correcto
    if ($_POST["_csrf"] != $_SESSION["_csrf"]) {
      redireccion("login?errCode=token"); // Si no es correcto redirijo a la página de login
    }

    // Compruebo si el formulario viene vacio
    if (empty($_POST["email"]) || empty($_POST["password"])) {
      redireccion("login?errCode=voidInput"); // Redirijo a la página de login
    }

    $user = User::loginUser($_POST["email"], $_POST["password"]);

    if (!is_null($user) && !is_bool($user)) {
      $_SESSION["user"] = serialize($user); // Guarda el user en la sesión
      $_SESSION["loginTime"] = time(); // Guarda el tiempo de inicio de sesión
      $_SESSION["loggedIn"] = true; // Guarda el estado de inicio de sesión
      redireccion("main");
    } else {
      redireccion("login?errCode=userNotFound"); // Redirijo a la página de login 
    }
  }

  /**
   * Cierra la sesión del user
   * @return
   */
  public function logout()
  {
    session_destroy();
    redireccion("login");
  }

  /**
   * Une un usuario a un evento
   * @return
   */
  public function joinEvent()
  {
    $user = unserialize($_SESSION["user"]);

    User_Join_Event::joinEvent($user->userId, $_GET["eventId"]);
    redireccion($_SERVER['HTTP_REFERER']); //Recarga la misma página de la que viene
  }

  /**
   * Saca a un usuario de un evento
   * @return
   */
  public function unjoinEvent()
  {
    $user = unserialize($_SESSION["user"]);

    User_Join_Event::unJoinEvent($user->userId, $_GET["eventId"]);
    redireccion($_SERVER['HTTP_REFERER']); //Recarga la misma página de la que viene
  }

  /**
   * Obtiene el número de seguidos de un usuario
   * @param int $userId
   * @return int
   */
  public static function getFollowedCount(int $userId): int
  {

    $followeds = User::getAllFollowedUsers($userId);

    //Evaluo el tipo de dato que devuelve la función y devuelvo el número de seguidores en función
    if (is_array($followeds)) {
      $followedCount = count($followeds);
    } else if (is_object($followeds)) {
      $followedCount = 1;
    } else {
      $followedCount = 0;
    }

    return $followedCount;
  }

  /**
   * Obtiene el número de seguidores de un usuario
   * @param int $userId
   * @return int
   */
  public static function getFollowersCount(int $userId): int
  {
    $followers = User::getAllFollowers($userId);

    // Evalúo el tipo de dato que devuelve la función y devuelvo el número de seguidores en función
    if (is_array($followers)) {
      $followersCount = count($followers);
    } else if (is_object($followers)) {
      $followersCount = 1;
    } else {
      $followersCount = 0;
    }

    return $followersCount;
  }

  /**
   * Obtiene el número de amigos de un usuario
   * @param int $userId
   * @return int
   */
  public static function getFriendsCount(int $userId): int
  {
    $friends = User::getAllFriends($userId);

    // Evalúo el tipo de dato que devuelve la función y devuelvo el número de seguidores en función
    if (is_array($friends)) {
      $friendsCount = count($friends);
    } else if (is_object($friends)) {
      $friendsCount = 1;
    } else {
      $friendsCount = 0;
    }

    return $friendsCount;
  }
}
