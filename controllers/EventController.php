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
        public static function loadEventParticipant(Event $event) {
            
            if ($event->participants != null) {

                $participants = $event->participants;
                $participantsArray = explode(",", $participants);

                array_push($_SESSION["eventParticipants"], $participantsArray);
            }
        } 

        /**
         * Esta función va a mostrar el formulario de cración de eventos
         */
        public function showCreateEvent() {

            $this->render("main/createEvent.twig");
    }
}