<?php

    require_once $_SESSION['rootPath']."/library/connection.php";

    class eventRequirement {

        public int $eventRequirementId;
        public ?string $maxRank;
        public ?string $minRank;
        public ?int $maxLvl;
        public ?int $minLvl;


        public function __construct()
        {
        }

        /**
         * Devuelve todos los requisitos de un evento
         * @param int $eventId
         * @return eventRequirement
         */
        public static function getEventRequirementById($id): ?eventRequirement {
                
                    // Establezco conexión con la base de datos
                    $db = Connection::getConnection();

                    if ($id == null) {
                        return null;
                    }
    
                    // Consulta a la base de datos, cogemos todas las columnas del requirement que coinciden con el ID pedido
                    $db->query("SELECT * FROM eventRequirement WHERE eventRequirementId = $id;");

                    $eventRequirement = $db->getRow("eventRequirement"); //Devuelve un objeto eventRequirement
    
                    //Devolvemos los requisitos de los eventos
                    return $eventRequirement;
        }

        /**
         * Crea un nuevo requisito de evento
         * @param string $maxRank
         * @param string $minRank
         * @param int $maxLvl
         * @param int $minLvl
         * @return eventRequirement
         */
        public static function createEventRequirement(string $maxRank, string $minRank, int $maxLvl, int $minLvl): int {

            // Establezco conexión con la base de datos
            $db = Connection::getConnection();

            // Consulta a la base de datos, insertamos los datos del evento
            $db->query("INSERT INTO eventRequirement (maxRank, minRank, maxLvl, minLvl) VALUES ('$maxRank', '$minRank', '$maxLvl', '$minLvl');");

            //Devolvemos el id el eventRequirement que acabamos de crear
            return $db->lastInsertId();
        }
    }