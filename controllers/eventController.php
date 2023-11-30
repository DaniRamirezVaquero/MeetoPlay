<?php

require_once $_SESSION['rootPath']."/library/extra_functs.php";
    require_once $_SESSION['rootPath']."/models/event.php";
    require_once $_SESSION['rootPath']."/models/user.php";
    require_once $_SESSION['rootPath']."/models/stat.php";
    require_once $_SESSION['rootPath']."/models/game.php";
    require_once $_SESSION['rootPath']."/controllers/controller.php";

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

            $this->render("main/createEvent.twig");
    }
}