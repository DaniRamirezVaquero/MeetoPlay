<?php

// TODO: Implementar gameModes como string separado con ':' en la base de datos y crear un array con los modos de juego

require_once $_SESSION['rootPath']."/library/connection.php";

class Game
{

        public int $gameId;
        public string $gameName;
        public ?string $gameLogo;

        public function __construct()
        {
        }

        /**
         * Devuelve todos los juegos
         * @return array
         */
        public static function getAllGames(): array {

                // Establezco conexión con la base de datos
                $db = Connection::getConnection();

                // Consulta a la base de datos, cogemos todos los juegos
                $db->query("SELECT * FROM game;");

                //Devolvemos los juegos
                return $db->getAll("game");
        }

        /**
         * Devuelve un juego por su Id
         * @param int $gameId
         * @return game
         */
        public static function getGameById(int $gameId): Game {

                // Establezco conexión con la base de datos
                $db = Connection::getConnection();

                // Consulta a la base de datos, cogemos el juego que coincide con el ID pedido
                $db->query("SELECT * FROM game WHERE gameId = $gameId;");
                $game = $db->getRow("Game"); //Devuelve un objeto game

                //Devolvemos el juego
                return $game;
        }


        /**
         * Devuelve el id de un juego por su nombre
         * @param string $gameName
         * @return int
         */
        public static function getGameIdByName(string $gameName): int {

                // Establezco conexión con la base de datos
                $db = Connection::getConnection();

                // Consulta a la base de datos, cogemos el juego que coincide con el ID pedido
                $db->query("SELECT gameId FROM game WHERE gameName = '$gameName';");
                $gameId = $db->getRow("Game"); //Devuelve un objeto game

                // Cierro la conexión con la base de datos
                $db->close();

                //Devolvemos el juego
                return $gameId->gameId;
        }
}
