<?php

require_once "library/extra_functs.php";
    require_once "models/Event.php";
    require_once "models/User.php";
    require_once "models/Stat.php";
    require_once "models/game.php";
    require_once "Controller.php";

    class EventController extends Controller {

        /**
         * Este metodo mostrará todos los eventos
         * @return
         */
        public function showAllEvents() {

            // TODO: Esto no debería de ir aquí

            $loggedInUser = unserialize($_SESSION["user"]);

            $events = Event::getAllEventsByFollowedUsers($loggedInUser->userId); // Cogemos todos los eventos de los usuarios seguidos por el usuario logeado
            $users = User::getAllFollowedUsers($loggedInUser->userId); // Cogemos todos los usuarios como array
            $userGameStats = Stat::getStatsByUserId($loggedInUser->userId); // Cogemos las estadisticas del usuario logeado
            $games = Game::getAllGames(); // Cogemos todos los juegos como array


            // Renderizamos el template con toda la infromacion necesaria
            $this->render("main/eventsFeed.twig", 
                                            [
                                                "events" => $events, 
                                                "users" => $users, 
                                                "logedUser" => unserialize($_SESSION["user"]), 
                                                "userGameStats" => $userGameStats , 
                                                "games" => $games]); 
        }

    }