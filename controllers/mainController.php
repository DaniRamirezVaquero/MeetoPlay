<?php

require_once $_SESSION['rootPath'] . "/library/extra_functs.php";

require_once $_SESSION['rootPath'] . "/models/event.php";
require_once $_SESSION['rootPath'] . "/models/eventOwner.php";
require_once $_SESSION['rootPath'] . "/models/user.php";
require_once $_SESSION['rootPath'] . "/models/stat.php";
require_once $_SESSION['rootPath'] . "/models/game.php";
require_once $_SESSION['rootPath'] . "/models/user_join_event.php";

require_once $_SESSION['rootPath'] . "/controllers/controller.php";
require_once $_SESSION['rootPath'] . "/controllers/eventController.php";


class mainController extends Controller
{

  /**
   * Prepara toda la información necesaria para el template base
   * @return array
   */
  public static function prepareBaseTemplateData(): array
  {

    // Cogemos el usuario logeado
    $loggedInUser = unserialize($_SESSION["user"]);

    $users = User::getAllUsers(); // Cogemos todos los usuarios como array
    $followedUsers = User::getAllFollowedUsers($loggedInUser->userId); // Cogemos todos los usuarios seguidos como array
    $userGameStats = Stat::getStatsByUserId($loggedInUser->userId); // Cogemos las estadisticas del usuario logeado
    $games = Game::getAllGames(); // Cogemos todos los juegos como array    

    // inicializamos el array
    $baseTemplateData = array();

    // Añadimos los datos al array
    $baseTemplateData =
      [
        "users" => $users,
        "followedUsers" => $followedUsers,
        "logedUser" => $loggedInUser,
        "userGameStats" => $userGameStats,
        "games" => $games
      ];

    return $baseTemplateData;
  }


  /**
   * Este metodo mostrará todos los eventos
   * @return
   */
  public function showMainPage()
  {
    checkAccess(); // Compruebo que no se está intentando acceder de manera ilegal

    // Renderizamos el template con toda la infromacion necesaria
    $this->render(
      "main/eventsFeed.twig",
      [
        "baseTemplateData" => $this->prepareBaseTemplateData(),
        "eventsData" => EventController::prepareEventsData()
      ]
    );
  }
}
