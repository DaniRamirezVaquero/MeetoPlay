<?php 

    require_once $_SESSION['rootPath']."/library/connection.php";

    class Follower_Followed {

        public int $followedId;
        public int $followerId;

    public static function getuserFollowed (int $userId): array {

        // Establezco conexión con la base de datos
        $db = Connection::getConnection();

        // Consulta a la base de datos, cogemos todos los eventos que coinciden con el ID pedido
        $db->query("SELECT * FROM follower_followed WHERE followerId = $userId;");
        $followed = $db->getAll("Follower_Followed"); //Devuelve un objeto event

        //Devolvemos los eventos
        return $followed;
    }
}