<?php

    require_once $_SESSION['rootPath']."/models/game.php";

    class gameController extends controller {

        /**
         * Comprueba si un juego existe en la base de datos
         * @param string $gameName
         * @return bool
         */
        public static function checkGame($gameName): bool {
            if (Game::gameExists($gameName)) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Devuelve el id de un juego por su nombre
         * @param string $gameName
         * @return int
         */
        public static function getGameIdByName($gameName): int {
            $gameId = Game::getGameIdByName($gameName);
            return $gameId;
        }
    }