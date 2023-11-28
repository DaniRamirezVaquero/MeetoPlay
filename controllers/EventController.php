<?php

require_once "library/extra_functs.php";
    require_once "models/Event.php";
    require_once "models/User.php";
    require_once "models/Stat.php";
    require_once "models/game.php";
    require_once "Controller.php";

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

            $this->render("event/createEvent.twig");
    }
}