<?php

    require_once $_SESSION['rootPath']."/library/connection.php";
    require_once $_SESSION['rootPath']."/models/user_join_event.php";

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