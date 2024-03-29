<?php

class EventOwner extends User
{

  public int $eventOwnerId;

  public function __construct()
  {
  }

  /**
   * Obtiene la información del propietario de un evento
   */
  public static function getEventOwnerData(int $eventId): User
  {
    $db = Connection::getConnection();

    $db->query("SELECT eventOwnerId, userName, profilePic FROM event E JOIN user U ON E.eventOwnerId = U.userId WHERE eventId = $eventId");

    return $db->getRow("eventowner");
  }
}
