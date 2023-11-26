<?php

    require_once "library/Connection.php";
    require_once "models/User_Join_Event.php";

    function UserJoinedEvent($eventId, $userId) {

        $db = Connection::getConnection();

        $db->query("SELECT * FROM user_join_event WHERE eventId = $eventId AND userId = $userId;");
        $userJoinedEvent = $db->getAll("User_Join_Event");

        if ($userJoinedEvent != null) {
            return true;
        } else {
            return false;
        }
    }