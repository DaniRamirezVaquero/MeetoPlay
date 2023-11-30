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

        
    }