<?php 


    class Connection {
        
        private static ?Connection $instance = null; // '?Connection' indica que puede ser null
        private $db; // Conexión con la base de data

        private $result; // Resultado de la consulta

        private function __clone() { } // El método __clone() se hace privado para evitar que se pueda clonar el objeto

        /**
         * Conectamos con el servidor de base de data unicamnete una vez
         * cuando creo la instacia de la class connection
         * @return mysqli
         */
        private function __construct() { // El constructor se hace privado para que no se puedan crear instancias de la class
            try {
                $this->db = new mysqli("db", "root", "", "MeetoPlayDB"); 
            
            } catch (mysqli_sql_exception $exp) {
                die("** Error al conectar: ".$exp->getMessage()."<br/>");   
            } 
        }
        
        /**
         * Crea una unica instacia de la conexion, la guarda y la devuelve
         * 
         * @return Connection
         */
        public static function getConnection(): Connection {
            if (self::$instance == null) { // Solo se crea la instance si no existe

                // Cremos la instancia de la class y conectamos a la base de data
                self::$instance = new Connection();
            }

            return self::$instance;
        }

        /**
         * Devuelve el resultado de la consulta
         * 
         * @param string $sql
         */
        public function query(string $sql) {
            
            $this->result = $this->db->query($sql);

            return $this; // Devuelve el objeto Connection, por lo tanto puedo encadenar métodos
        }

        /**
         * Devuelve una sola fila de la consulta
         * @param string $class Nombre de la class a la que se va a convertir el objeto
         * @return object
         */
        public function getRow(string $class): ?object {
            return $this->result->fetch_object($class);
        }

        /**
         * Cierra la conexión con la base de data
         */
        public function close() {
            $this->db->close();
        }

        /**
         * Devuelve un array de objetos de la consulta
         * @param string $class Nombre de la class a la que se va a convertir el objeto
         * @return array
         */
        public function getAll(string $class): array {
            $data = [];
            while ($row = $this->getRow($class)) {
                array_push($data, $row);
            }
            return $data;
        }
    }