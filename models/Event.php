<?php

    require_once "library/Connection.php";
    require_once "models/User.php";
    require_once "models/EventRequirement.php";


    class event{

        public int $eventId;
        public string $eventTitle;
        public int $gameId;
        public string $gameMode;
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
        public static function getAllEventsByUserId(int $userId): array {
                
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
        public static function getAllEventsByFollowedUsers(int $userId): array {
                
                // Establezco conexión con la base de datos
                $db = Connection::getConnection();
    
                // Consulta a la base de datos, cogemos todos los eventos que coinciden con el ID pedido
                $db->query("SELECT * FROM event WHERE eventOwnerId IN (SELECT followedId FROM follower_followed WHERE followerId = " . $userId . ");");    
                $events = $db->getAll("Event"); //Devuelve un objeto event
    
                //Devolvemos los eventos
                return $events;
        }

        public static function getAllEvents(): array {
                
                // Establezco conexión con la base de datos
                $db = Connection::getConnection();
    
                // Consulta a la base de datos, cogemos todos los eventos
                $db->query("SELECT * FROM event;");    
    
                //Devolvemos los eventos
                return $db->getAll("event");
        }
    }