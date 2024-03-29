<?php

require_once $_SESSION['rootPath'] . "/library/extra_functs.php";
require_once $_SESSION['rootPath'] . "/library/connection.php";
require_once $_SESSION['rootPath'] . "/models/user.php";
require_once $_SESSION['rootPath'] . "/models/eventRequirement.php";


class event
{

  public int $eventId;
  public string $eventTitle;
  public int $gameId;
  public string $gameMode;
  public string $platform;
  public int $eventOwnerId;
  public string $dateBegin;
  public string $dateEnd;
  public string $hourBegin;
  public string $hourEnd;
  public ?int $eventRequirementId;
  public ?string $participants;
  public int $slots;
  public string $dateInscriptionBegin;
  public string $dateInscriptionEnd;
  public string $hourInscriptionBegin;
  public string $hourInscriptionEnd;


  public function __construct()
  {
  }


  /**
   * Devuelve todos los eventos de un usuario
   * @param int $userId
   * @return array
   */
  public static function getAllEventsByUserId(int $userId): array
  {

    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Consulta a la base de datos, cogemos todos los eventos que coinciden con el ID pedido
    $db->query("SELECT * FROM event WHERE eventOwnerId = $userId;");
    $events = $db->getAll("Event"); //Devuelve un objeto event

    //Devolvemos los eventos
    return $events;
  }

  /**
   * Devuelve los eventos publicados por los seguidos del usuario
   * @param int $userId
   * @return array
   */
  public static function getAllEventsByFollowedUsers(int $userId): array
  {

    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Consulta a la base de datos, cogemos todos los eventos que coinciden con el ID pedido
    $db->query("SELECT * FROM event WHERE eventOwnerId IN (SELECT followedId FROM follower_followed WHERE followerId = " . $userId . ");");
    $events = $db->getAll("Event"); //Devuelve un objeto event

    //Devolvemos los eventos
    return $events;
  }

  public static function getAllEvents(): array
  {

    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Consulta a la base de datos, cogemos todos los eventos
    $db->query("SELECT * FROM event;");

    //Devolvemos los eventos
    return $db->getAll("event");
  }

  /**
   * Formatea la fecha para que se muestre correctamente en la tarjeta del evento
   * @param string $date
   * @return string
   */
  public static function formatDate(string $date)
  {
    $date = date_create($date);
    return date_format($date, 'd/m/Y');
  }

  /**
   * Formatea la hora para que se muestre correctamente en la tarjeta del evento
   * @param string $hour
   * @return string
   */
  public static function formatHour(string $hour)
  {
    $hour = date_create($hour);
    return date_format($hour, 'H:i');
  }

  /**
   * Añade el nombre del usuario en la lista de participantes del evento
   * @param int $userId
   * @param int $eventId
   */
  public static function addParticipant(int $userId, int $eventId)
  {

    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Consulta a la base de datos, cogemos todos los eventos que coinciden con el ID pedido
    $db->query("SELECT participants FROM event WHERE eventId = $eventId;");
    $participants = $db->getRow("Event")->participants; //Devuelve el evento

    //Cogemos el nombre del usuario
    $db->query("SELECT userName FROM user WHERE userId = $userId;");
    $userName = $db->getRow("User")->userName; //Devuelve el usuario

    //Añadimos el id del usuario a la lista de participantes
    if ($participants == null) {
      $participants = $userName; //Si no hay participantes, añadimos el nombre del usuario
    } else {
      $participants = $userName . "," . $participants; //Si ya hay participantes, añadimos el nombre del usuario con una ","
    }


    //Actualizamos la base de datos
    $db->query("UPDATE event SET participants = '$participants' WHERE eventId = $eventId;");
  }

  /**
   * Elimina el nombre del usuario de la lista de participantes del evento
   * @param int $userId
   * @param int $eventId
   */
  public static function removeParticipant(int $userId, int $eventId)
  {

    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Consulta a la base de datos, cogemos todos los eventos que coinciden con el ID pedido
    $db->query("SELECT participants FROM event WHERE eventId = $eventId;");
    $participants = $db->getRow("Event")->participants; //Devuelve el evento

    //Cogemos el nombre del usuario
    $db->query("SELECT userName FROM user WHERE userId = $userId;");
    $userName = $db->getRow("User")->userName; //Devuelve el usuario

    // Eliminamos el id del usuario de la lista de participantes
    if ($participants == $userName) { //Si solo hay un participante y es el usuario
      $participants = null;
    } else {
      $participants = str_replace($userName . ",", "", $participants); //Si hay más de un participante, eliminamos el nombre del usuario de la lista
    }


    //Actualizamos la base de datos
    $db->query("UPDATE event SET participants = '$participants' WHERE eventId = $eventId;");
  }

  /**
   * Inserta un nuevo evento en la base de datos
   * @param int $userId
   * @param string $eventTitle
   * @param int $gameId
   * @param string $gameMode
   * @param string $platform
   * @param string $dateBegin
   * @param string $dateEnd
   * @param string $hourBegin
   * @param string $hourEnd
   * @param int $slots
   * @param string $dateInscriptionBegin
   * @param string $hourInscriptionBegin
   * @param string $dateInscriptionEnd
   * @param string $hourInscriptionEnd
   */
  public static function createEvent(
    int $userId,
    string $eventTitle,
    string $platform,
    int $gameId,
    string $gameMode,
    string $dateBegin,
    string $hourBegin,
    string $dateEnd,
    string $hourEnd,
    string $dateInscriptionBegin,
    string $hourInscriptionBegin,
    string $dateInscriptionEnd,
    string $hourInscriptionEnd,
    int $slots,
    ?int $eventRequirementId
  ) {

    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    if ($eventRequirementId == null) {
      $eventRequirementId = "NULL";
    }

    // Insertamos el evento en la base de datos
    $db->query("INSERT INTO event 
            ( eventTitle, gameId, gameMode, platform, eventOwnerId, dateBegin, dateEnd, hourBegin, hourEnd, eventRequirementId, slots, dateInscriptionBegin, dateInscriptionEnd, hourInscriptionBegin, hourInscriptionEnd, participants) 
            VALUES 
            ('$eventTitle', $gameId, '$gameMode', '$platform', $userId, '$dateBegin', '$dateEnd', '$hourBegin', '$hourEnd', $eventRequirementId, $slots, '$dateInscriptionBegin', '$dateInscriptionEnd', '$hourInscriptionBegin' ,'$hourInscriptionEnd', NULL);");
  }

  /**
   * Actualiza un evento
   * @param int $eventId
   * @param string $eventTitle
   * @param int $gameId
   * @param string $gameMode
   * @param string $platform
   * @param string $dateBegin
   * @param string $dateEnd
   * @param string $hourBegin
   * @param string $hourEnd
   * @param int $slots
   * @param string $dateInscriptionBegin
   * @param string $hourInscriptionBegin
   * @param string $dateInscriptionEnd
   * @param string $hourInscriptionEnd
   */
  public static function updateEvent(
    int $eventId,
    string $eventTitle,
    string $platform,
    int $gameId,
    string $gameMode,
    string $dateBegin,
    string $hourBegin,
    string $dateEnd,
    string $hourEnd,
    string $dateInscriptionBegin,
    string $hourInscriptionBegin,
    string $dateInscriptionEnd,
    string $hourInscriptionEnd,
    int $slots,
    ?int $eventRequirementId
  ) {

    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    if ($eventRequirementId == null) {
      $eventRequirementId = "NULL";
    }

    // Actualizamos el evento en la base de datos
    $db->query("UPDATE event SET 
                eventTitle = '$eventTitle', 
                gameId = $gameId, 
                gameMode = '$gameMode', 
                platform = '$platform', 
                dateBegin = '$dateBegin', 
                dateEnd = '$dateEnd', 
                hourBegin = '$hourBegin', 
                hourEnd = '$hourEnd', 
                eventRequirementId = $eventRequirementId, 
                slots = $slots, 
                dateInscriptionBegin = '$dateInscriptionBegin', 
                dateInscriptionEnd = '$dateInscriptionEnd', 
                hourInscriptionBegin = '$hourInscriptionBegin', 
                hourInscriptionEnd = '$hourInscriptionEnd' 
                WHERE eventId = $eventId;");
  }


  /**
   * Devuelve los eventos creados por un usuario
   * @param int $userId
   * @return array
   */
  public static function getEventsByOwnerId(int $userId): array
  {

    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Consulta a la base de datos, cogemos todos los eventos que coinciden con el ID pedido
    $db->query("SELECT * FROM event WHERE eventOwnerId = $userId;");
    $events = $db->getAll("Event"); //Devuelve un objeto event

    //Devolvemos los eventos
    return $events;
  }

  /**
   * Elimina un evento
   * @param int $eventId
   */
  public static function deleteEventById(int $eventId)
  {

    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Eliminamos el evento de la base de datos
    $db->query("DELETE FROM event WHERE eventId = $eventId;");
  }

  /**
   * Devuelve un evento por su Id
   * @param int $eventId
   * @return event
   */
  public static function getEventById(int $eventId): event
  {

    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Consulta a la base de datos, cogemos el evento que coinciden con el ID pedido
    $db->query("SELECT * FROM event WHERE eventId = $eventId;");
    $event = $db->getRow("Event"); //Devuelve un objeto event

    //Devolvemos el evento
    return $event;
  }
}
