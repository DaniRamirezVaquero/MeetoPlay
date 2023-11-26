<?php

require_once "library/extra_functs.php";

    require_once "models/Event.php";
    require_once "models/EventOwner.php";
    require_once "models/User.php";
    require_once "models/Stat.php";
    require_once "models/game.php";
    require_once "models/User_Join_Event.php";

    require_once "Controller.php";
    require_once "EventController.php";


class mainController extends Controller
{

    /**
     * Este metodo mostrará todos los eventos
     * @return
     */
    public function showMainPage()
    {   
        $loggedInUser = unserialize($_SESSION["user"]);

        //TODO: Guardar la información en la clase TwigExtension o en $_SESSION para no tener que hacer tantas llamadas a la base de datos

        $events = Event::getAllEventsByFollowedUsers($loggedInUser->userId); // Cogemos todos los eventos de los usuarios seguidos por el usuario logeado

        //TODO: Mejor manera de hacer esto (?
        //Antes de enviar events formateo la hora y la fecha
        foreach ($events as $event) {
                $event->dateBegin = $event->formatDate($event->dateBegin);
                $event->dateEnd = $event->formatDate($event->dateEnd);
                $event->hourBegin = $event->formatHour($event->hourBegin);
                $event->hourEnd = $event->formatHour($event->hourEnd);
                $event->dateInscriptionEnd = $event->formatDate($event->dateInscriptionEnd);
                $event->hourInscriptionEnd = $event->formatHour($event->hourInscriptionEnd);
        }

        // Inicializa la variable de sesión como un array si aún no existe
        if (!isset($_SESSION["eventParticipants"])) {
            $_SESSION["eventParticipants"] = array();
        } else {
            // Si ya existe, borra el array para que no se duplique
            $_SESSION["eventParticipants"] = [];
        }

        //Cojo todos los eventRequirement de los eventos
        $eventsRequirements = [];
        foreach ($events as $event) {
            if ($event->eventRequirementId != null) {
                array_push($eventsRequirements, eventRequirement::getEventRequirementById($event->eventRequirementId));
            }

            //Guardo los participantes de cada evento en la sesión
            EventController::loadEventParticipant($event);
        }

        $users = User::getAllUsers(); // Cogemos todos los usuarios como array
        $followedUsers = User::getAllFollowedUsers($loggedInUser->userId); // Cogemos todos los usuarios seguidos como array
        $userGameStats = Stat::getStatsByUserId($loggedInUser->userId); // Cogemos las estadisticas del usuario logeado
        $games = Game::getAllGames(); // Cogemos todos los juegos como array

        // Renderizamos el template con toda la infromacion necesaria
        $this->render(
            "main/eventsFeed.twig",
            [
                "session" => $_SESSION,
                "events" => $events,
                "eventsRequirements" => $eventsRequirements,
                "users" => $users, 
                "followedUsers" => $followedUsers,
                "logedUser" => $loggedInUser,
                "userGameStats" => $userGameStats,
                "games" => $games
            ]
        );
    }
}
