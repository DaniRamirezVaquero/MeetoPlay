<?php

require_once $_SESSION['rootPath']."/library/extra_functs.php";

    require_once $_SESSION['rootPath']."/models/event.php";
    require_once $_SESSION['rootPath']."/models/eventOwner.php";
    require_once $_SESSION['rootPath']."/models/user.php";
    require_once $_SESSION['rootPath']."/models/stat.php";
    require_once $_SESSION['rootPath']."/models/game.php";
    require_once $_SESSION['rootPath']."/models/user_join_event.php";

    require_once $_SESSION['rootPath']."/controllers/controller.php";
    require_once $_SESSION['rootPath']."/controllers/eventController.php";


class mainController extends Controller
{


    public function prepareTemplateData(): array {

        $loggedInUser = unserialize($_SESSION["user"]);

        $events = Event::getAllEventsByFollowedUsers($loggedInUser->userId); // Cogemos todos los eventos de los usuarios seguidos por el usuario logeado

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
        }

        
        $users = User::getAllUsers(); // Cogemos todos los usuarios como array
        $followedUsers = User::getAllFollowedUsers($loggedInUser->userId); // Cogemos todos los usuarios seguidos como array
        $userGameStats = Stat::getStatsByUserId($loggedInUser->userId); // Cogemos las estadisticas del usuario logeado
        $games = Game::getAllGames(); // Cogemos todos los juegos como array
        $eventsParticipants = EventController::getEventsParticipants($loggedInUser->userId); // Cogemos todos los participantes de los eventos de los usuarios seguidos por el usuario logeado

        $data = [];
        $data = 
        [
            "events" => $events,
            "eventsRequirements" => $eventsRequirements,
            "eventsParticipants" => $eventsParticipants,
            "users" => $users, 
            "followedUsers" => $followedUsers,
            "logedUser" => $loggedInUser,
            "userGameStats" => $userGameStats,
            "games" => $games
        ];

        return $data;
    }

    //TODO: Por que al redireccionar y volver a renderizar no se actualizan los datos en la vista?
    /**
     * Este metodo mostrará todos los eventos
     * @return
     */
    public function showMainPage()
    {   
        // Renderizamos el template con toda la infromacion necesaria
        $this->render(
            "main/eventsFeed.twig",
            [
                "session" => $_SESSION,
                "data" => $this->prepareTemplateData()
            ]
        );
    }
}
