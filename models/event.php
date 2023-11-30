<?php

require_once $_SESSION['rootPath']."/library/extra_functs.php";
require_once $_SESSION['rootPath']."/library/connection.php";
require_once $_SESSION['rootPath']."/models/user.php";
require_once $_SESSION['rootPath']."/models/eventRequirement.php";


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
        public string $dateInscriptionEnd;
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
         * Formatea la fecha y la hora para que se muestre correctamente en la tarjeta del evento
         * @param string $date
         * @param string $hour
         * @
         */

        public static function formatDate (string $date)  {
                $date = date_create($date);
                return date_format($date, 'd/m/Y');
        }

        public static function formatHour (string $hour) {
                $hour = date_create($hour);
                return date_format($hour, 'H:i');
        }

        /**
         * Añade el nombre del usuario en la lista de participantes del evento
         * @param int $userId
         * @param int $eventId
         */
        public static function addParticipant(int $userId, int $eventId) {
                        
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
        public static function removeParticipant(int $userId, int $eventId) {
                        
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
                        $participants = str_replace($userName.",", "", $participants); //Si hay más de un participante, eliminamos el nombre del usuario de la lista
                }


                //Actualizamos la base de datos
                $db->query("UPDATE event SET participants = '$participants' WHERE eventId = $eventId;");
        }
}
