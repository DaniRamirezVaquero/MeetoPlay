<?php

    require_once $_SESSION['rootPath']."/library/connection.php";
    require_once $_SESSION['rootPath']."/models/event.php";

    class User_Join_Event {

        public int $userId;
        public int $eventId;

        static function getJoinedEventsByUserId (int $userId): array {

            // Establezco conexión con la base de datos
            $db = Connection::getConnection();

            // Consulta a la base de datos, cogemos todos los eventos que coinciden con el ID pedido
            $db->query("SELECT * FROM user_join_event WHERE userId = $userId;");
            $joinedEvents = $db->getAll("User_Join_Event"); //Devuelve un array con el id de los eventos a los que sea ha unido el usuario

            //Devolvemos los eventos
            return $joinedEvents;
        }

        static function joinEvent (int $userId, int $eventId) {

            // Establezco conexión con la base de datos
            $db = Connection::getConnection();

            Event::addParticipant($userId, $eventId);

            // Consulta a la base de datos, cogemos todos los eventos que coinciden con el ID pedido
            $db->query("INSERT INTO user_join_event (userId, eventId) VALUES ($userId, $eventId);");

        }

        static function unjoinEvent (int $userId, int $eventId) {

            // Establezco conexión con la base de datos
            $db = Connection::getConnection();

            Event::removeParticipant($userId, $eventId);

            // Consulta a la base de datos, cogemos todos los eventos que coinciden con el ID pedido
            $db->query("DELETE FROM user_join_event WHERE userId = $userId AND eventId = $eventId;");
        }
    }