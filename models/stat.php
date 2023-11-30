<?php

    require_once $_SESSION['rootPath']."/library/connection.php";

    class Stat {

        public int $statId;
        public int $gameId;
        public int $userId;
        public int $level;
        public string $maxRank;
        public string $timePlayed;
        public string $favGameMode;
        public string $inGameName;

        public function __construct()
        {
        }

        /**
         * Devuelve todas las estadísticas de un usuario
         * @param int $userId
         * @return
         */
        public static function getStatsByUserId(int $userId): array {
                
                // Establezco conexión con la base de datos
                $db = Connection::getConnection();
    
                // Consulta a la base de datos, cogemos las estadísticas que coinciden con el ID pedido
                $db->query("SELECT * FROM stat WHERE userId = $userId;");    
                $stats = $db->getAll("Stat"); //Devuelve un objeto stat
    
                return $stats;
        }

        /**
         * Devuelve las estadísticas de un usuario en un juego
         * @param int $userId
         * @param int $gameId
         * @return
         */
        public static function getStatByUserIdAndGameId(int $userId, int $gameId): Stat {
                
                // Establezco conexión con la base de datos
                $db = Connection::getConnection();
    
                // Consulta a la base de datos, cogemos las estadísticas que coinciden con el ID pedido
                $db->query("SELECT * FROM stat WHERE userId = $userId AND gameId = $gameId;");
                $stat = $db->getRow("Stat"); //Devuelve un objeto stat
    
                //Devolvemos las estadísticas
                return $stat;
    }
}