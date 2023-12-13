<?php

require_once $_SESSION['rootPath'] . "/library/extra_functs.php";
require_once $_SESSION['rootPath'] . "/models/event.php";
require_once $_SESSION['rootPath'] . "/models/user.php";
require_once $_SESSION['rootPath'] . "/models/stat.php";
require_once $_SESSION['rootPath'] . "/models/game.php";
require_once $_SESSION['rootPath'] . "/controllers/mainController.php";
require_once $_SESSION['rootPath'] . "/controllers/controller.php";
require_once $_SESSION['rootPath'] . "/controllers/gameController.php";

class EventController extends Controller
{
  /**
   * Comprueba que el que intenta editar o borrar el evento es el dueño de dicho evento
   * @return
   */
  public function checkEventOwner(int $eventId): bool {
    $event = Event::getEventById($eventId);
    $loggedInUser = unserialize($_SESSION["user"]);

    if ($event->eventOwnerId == $loggedInUser->userId) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Esta función devuelve los participantes de un evento
   * @param int $userId
   * @return array
   */
  public static function getEventsParticipants(int $userId): array
  {
    // Cogemos todos los eventos de los usuarios seguidos por el usuario logeado
    $events = Event::getAllEventsByFollowedUsers($userId);
    $eventParticipants = [];

    //Creo un array con los participantes de cada evento y los voy metiendo en el array $eventParticipants
    foreach ($events as $event) {
      //Separamos los participantes por comas
      $participantsArray = $event->participants ? explode(",", $event->participants) : []; // Si el evento no tiene participantes, el array será vacío
      $eventParticipants[] = $participantsArray;
    }

    return $eventParticipants;
  }

  /**
   * Esta función va a mostrar el formulario de creación de eventos
   */
  public function showCreateEvent()
  {
    checkAccess(); // Compruebo que no se está intentando acceder de manera ilegal

    // Cogemos todos los datos necesarios para el baseTemplate
    $baseTemplateData = mainController::prepareBaseTemplateData();

    // Cogemos el código de error si lo hay
    $errCode = $_GET["errCode"] ?? null;

    $this->render("main/createEvent.twig", ["baseTemplateData" => $baseTemplateData, "errCode" => $errCode]);
  }

  /**
   * Muestra el formulario para editar el evento
   */
  public function showEditEvent()
  {

    checkAccess(); // Compruebo que no se está intentando acceder de manera ilegal
    
    if ($this->checkEventOwner($_GET["eventId"])) { // Compruebo que el que intenta editar el evento es el dueño del evento
      $baseTemplateData = mainController::prepareBaseTemplateData();
      $event = Event::getEventById($_GET["eventId"]);
      $eventRequirement = eventRequirement::getEventRequirementById($event->eventRequirementId);
      $game = game::getGameById($event->gameId);
  
      $errCode = $_GET["errCode"] ?? null;
  
      $this->render("main/editEvent.twig", ["baseTemplateData" => $baseTemplateData, "event" => $event, "eventRequirement" => $eventRequirement, "game" => $game, "errCode" => $errCode]);
    } else {
      redireccion("/main");
    }
  }

  /**
   * Prepara toda la información de los eventos
   * @return array
   */
  public static function prepareEventsData(): array
  {

    $loggedInUser = unserialize($_SESSION["user"]);

    $events = Event::getAllEventsByFollowedUsers($loggedInUser->userId); // Cogemos todos los eventos de los usuarios seguidos por el usuario logeado
    $eventsParticipants = EventController::getEventsParticipants($loggedInUser->userId); // Cogemos todos los participantes de los eventos de los usuarios seguidos por el usuario logeado

    //Antes de enviar events formateo la hora y la fecha
    formatEventsDateTime($events);

    //Cojo todos los requesitos de los eventos
    $eventsRequirements = [];
    foreach ($events as $event) {
      if ($event->eventRequirementId != null) {
        array_push($eventsRequirements, eventRequirement::getEventRequirementById($event->eventRequirementId));
      } else {
        array_push($eventsRequirements, null);
      }
    }

    // Se almacena la información de los eventos en un array asociativo
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
  public function createNewEvent()
  {

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
    if ($_POST["minLvl"] == null && $_POST["maxLvl"] == null && $_POST["minRank"] == null && $_POST["maxRank"] == null) {
      $eventRequirementId = null;
    } else {

      $minLvl = $_POST["minLvl"] == null ? null : intval($_POST["minLvl"]);
      $maxLvl = $_POST["maxLvl"] == null ? null : intval($_POST["maxLvl"]);

      //Creo los requisitos del evento
      $eventRequirementId = eventRequirement::createEventRequirement($_POST["maxRank"], $_POST["minRank"], $maxLvl, $minLvl);

    }

    //Cogemos el id del juego
    $gameId = gameController::getGameIdByName($_POST["eventGame"]);

    event::createEvent(
      unserialize($_SESSION["user"])->userId,
      $_POST["eventTitle"],
      $_POST["eventPlatform"],
      $gameId,
      $_POST["eventGameMode"],
      $_POST["dateBegin"],
      $_POST["hourBegin"],
      $_POST["dateEnd"],
      $_POST["hourEnd"],
      $_POST["inscriptionDateBegin"],
      $_POST["inscriptionHourBegin"],
      $_POST["inscriptionDateEnd"],
      $_POST["inscriptionHourEnd"],
      $_POST["slots"],
      $eventRequirementId
    );

    // Redirigimos a la página principal al terminar la inserción
    redireccion("main");
  }

  /**
   * Devuelve los eventos de un usuario
   * @return array
   */
  public static function getUserEvents(int $userId): array
  {
    $events = Event::getAllEventsByUserId($userId); // Cogemos todos los eventos de los usuarios seguidos por el usuario logeado

    //Antes de enviar events formateo la hora y la fecha
    formatEventsDateTime($events);

    //Cojo todos los eventRequirement de los eventos
    $eventsRequirements = [];
    foreach ($events as $event) {
      if ($event->eventRequirementId != null) {
        array_push($eventsRequirements, eventRequirement::getEventRequirementById($event->eventRequirementId));
      }
    }

    // Se almacena la información de los eventos del usuario en un array asociativo
    $eventsData = [
      "events" => $events,
      "eventsRequirements" => $eventsRequirements,
    ];

    return $eventsData;
  }

  /**
   * Devuelve todos los eventos creados por un usuario
   * @return array
   */
  public static function getAllEventsByOwnerId(int $userId): array
  {

    $events = Event::getEventsByOwnerId($userId); // Cogemos todos los eventos creados por el usuario
    formatEventsDateTime($events); // Formateamos la fecha y la hora de los eventos

    return $events;
  }

  /**
   * Elimina un evento por su Id
   * @return
   */
  public function deleteEvent()
  {
    if ($this->checkEventOwner($_GET["eventId"])) {
      // Cogemos el evento por su id
      $event = Event::getEventById($_GET["eventId"]);

      // Eliminamos el evento
      Event::deleteEventById($_GET["eventId"]);

      // Si el evento tenía requisitos, los borramos
      if ($event->eventRequirementId != null) {
        eventRequirement::deleteEventRequirement($event->eventRequirementId);
      }

      redireccion($_SERVER["HTTP_REFERER"]);

    } else {
      redireccion("/main");
    }
  }

  /**
   * Edita un evento
   * @return
   */
  public function editEvent()
  {

    if (!$this->checkEventOwner($_POST["eventId"])) { // Compruebo que el que intenta editar el evento es el dueño del evento
      redireccion("main");
    }

    //Compruebo que la fecha de inicio no sea mayor que la fecha de fin (evento)
    if ($_POST["dateBegin"] > $_POST["dateEnd"]) {
      redireccion("editEvent?eventId=" . $_POST["eventId"] . "&errCode=wrongeventDate"); // Redirijo a la página de creación de evento con mensaje de error
    }

    //Compruebo que la fecha de inicio no sea mayor que la fecha de fin (inscripcion)
    if ($_POST["inscriptionDateBegin"] > $_POST["inscriptionDateEnd"]) {
      redireccion("editEvent?eventId=" . $_POST["eventId"] . "&errCode=wrongInscriptionDate"); // Redirijo a la página de creación de evento con mensaje de error
    }

    //Compruebo que las plazas no sean negativas
    if ($_POST["slots"] < 0) {
      redireccion("editEvent?eventId=" . $_POST["eventId"] . "&errCode=negativeSlots"); // Redirijo a la página de creación de evento con mensaje de error
    }

    //Compruebo que el juego existe en la base de datos
    if (!gameController::checkGame($_POST["eventGame"])) {
      redireccion("editEvent?eventId=" . $_POST["eventId"] . "&errCode=gameNotFound"); // Redirijo a la página de creación de evento con mensaje de error
    }

    //Compruebo si el evento tiene requisitos
    $eventRequirementId = Event::getEventById($_POST["eventId"])->eventRequirementId;

    //Si el evento tiene requisitos, los actualizo
    if ($eventRequirementId != null) {
        eventRequirement::updateEventRequirement(
          $eventRequirementId,
          $_POST["maxRank"],
          $_POST["minRank"],
          $_POST["maxLvl"],
          $_POST["minLvl"]
        );
    }

    //Cogemos el id del juego
    $gameId = intval(gameController::getGameIdByName($_POST["eventGame"]));

    $eventId = intval($_POST["eventId"]);

    // Actualizamos el evento
    event::updateEvent(
      $eventId,
      $_POST["eventTitle"],
      $_POST["eventPlatform"],
      $gameId,
      $_POST["eventGameMode"],
      $_POST["dateBegin"],
      $_POST["hourBegin"],
      $_POST["dateEnd"],
      $_POST["hourEnd"],
      $_POST["inscriptionDateBegin"],
      $_POST["inscriptionHourBegin"],
      $_POST["inscriptionDateEnd"],
      $_POST["inscriptionHourEnd"],
      $_POST["slots"],
      $eventRequirementId
    );

    // Redirigimos al perfil del usuario al terminar la actualización
    redireccion("/userProfile/" . unserialize($_SESSION["user"])->userId);
  }
}
