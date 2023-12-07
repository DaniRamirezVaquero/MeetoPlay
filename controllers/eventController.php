<?php

require_once $_SESSION['rootPath']."/library/extra_functs.php";
    require_once $_SESSION['rootPath']."/models/event.php";
    require_once $_SESSION['rootPath']."/models/user.php";
    require_once $_SESSION['rootPath']."/models/stat.php";
    require_once $_SESSION['rootPath']."/models/game.php";
    require_once $_SESSION['rootPath']."/controllers/mainController.php";
    require_once $_SESSION['rootPath']."/controllers/controller.php";
    require_once $_SESSION['rootPath']."/controllers/gameController.php";

    class EventController extends Controller {

        /**
         * Esta función guarda en la sessión los participantes de un evento
         * @param Event $event
         */
        public static function getEventsParticipants($userId): array {
            
            $events = Event::getAllEventsByFollowedUsers($userId); // Cogemos todos los eventos de los usuarios seguidos por el usuario logeado

            $eventParticipants = [];

            foreach ($events as $event) {

                if ($event->participants == null) {
                    $participantsArray = [];
                } else {
                    $participantsArray = explode(",", $event->participants);
                }

                array_push($eventParticipants, $participantsArray);
            }
                
            return $eventParticipants;
        } 

        /**
         * Esta función va a mostrar el formulario de cración de eventos
         */
        public function showCreateEvent() {

            $baseTemplateData = mainController::prepareBaseTemplateData();
            $errCode = $_GET["errCode"] ?? null;

            $this->render("main/createEvent.twig", ["baseTemplateData" => $baseTemplateData, "errCode" => $errCode]);
        }

    /**
     * Prepara toda la información de los eventos
     * @return array
     */
    public static function prepareEventsData():array {

        $loggedInUser = unserialize($_SESSION["user"]);

        $events = Event::getAllEventsByFollowedUsers($loggedInUser->userId); // Cogemos todos los eventos de los usuarios seguidos por el usuario logeado
        $eventsParticipants = EventController::getEventsParticipants($loggedInUser->userId); // Cogemos todos los participantes de los eventos de los usuarios seguidos por el usuario logeado


        //Antes de enviar events formateo la hora y la fecha
        foreach ($events as $event) {
            $event->dateBegin = $event->formatDate($event->dateBegin);
            $event->dateEnd = $event->formatDate($event->dateEnd);
            $event->hourBegin = $event->formatHour($event->hourBegin);
            $event->hourEnd = $event->formatHour($event->hourEnd);
            $event->dateInscriptionEnd = $event->formatDate($event->dateInscriptionEnd);
            $event->hourInscriptionEnd = $event->formatHour($event->hourInscriptionEnd);
        }

        //Cojo todos los eventRequirement de los eventos
        $eventsRequirements = [];
        foreach ($events as $event) {
            if ($event->eventRequirementId != null) {
                array_push($eventsRequirements, eventRequirement::getEventRequirementById($event->eventRequirementId));
            }
        }
    
        $eventsData = [
            "events" => $events,
            "eventsParticipants" => $eventsParticipants,
            "eventsRequirements" => $eventsRequirements,
        ];

        return $eventsData;
    }

    /**
     * Registra un evento en la base de datos
     * @return
     */
    public function createNewEvent(){

        //Compruebo que la fecha de inicio no sea mayor que la fecha de fin (evento)
        if ($_POST["dateBegin"] > $_POST["dateEnd"]) {
            redireccion("newEvent?errCode=wrongeventDate"); // Redirijo a la página de creación de evento con mensaje de error
        }

        //Compruebo que la fecha de inicio no sea mayor que la fecha de fin (inscripcion)
        if ($_POST["inscriptionDateBegin"] > $_POST["inscriptionDateEnd"]) {
            redireccion("newEvent?errCode=wrongInscriptionDate"); // Redirijo a la página de creación de evento con mensaje de error
        }

        //Compruebo que las plazas no sean negativas
        if ($_POST["slots"] < 0) {
            redireccion("newEvent?errCode=negativeSlots"); // Redirijo a la página de creación de evento con mensaje de error
        }

        //Compruebo que el juego existe en la base de datos
        if (!gameController::checkGame($_POST["eventGame"])) {
            redireccion("newEvent?errCode=gameNotFound"); // Redirijo a la página de creación de evento con mensaje de error
        }

        //Si todos los campos de los requisitos están vacíos, el evento no tiene requisitos
        if ($_POST["minLvl"]==null && $_POST["maxLvl"]==null && $_POST["minRank"]==null && $_POST["maxRank"]==null){
            $eventRequirementId = null;
        } else {
                    //Creo los requisitos del evento
        $eventRequirement = eventRequirement::createEventRequirement($_POST["minLvl"], $_POST["maxLvl"], $_POST["minRank"], $_POST["maxRank"]);

        //Cogemos el id del eventoRequirement
        $eventRequirementId = $eventRequirement->eventRequirementId;
        }



        //Cogemos el id del juego
        $gameId = gameController::getGameIdByName($_POST["eventGame"]);

        event::createEvent
        (
                unserialize($_SESSION["user"])->userId,
                $_POST["eventTitle"], $_POST["eventPlatform"], 
                $gameId,  $_POST["eventGameMode"], 
                $_POST["dateBegin"],  $_POST["hourBegin"], 
                $_POST["dateEnd"],    $_POST["hourEnd"],
                $_POST["inscriptionDateBegin"], $_POST["inscriptionHourBegin"], 
                $_POST["inscriptionDateEnd"], $_POST["inscriptionHourEnd"],
                $_POST["slots"], $eventRequirementId
            );

        redireccion("main");
    }
}