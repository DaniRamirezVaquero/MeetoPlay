<?php 

    require_once $_SESSION['rootPath']."/library/extra_functs.php";

    class Connection {
        
        private static ?Connection $instance = null; // '?Connection' indica que puede ser null
        private $db; // Conexión con la base de datos

        private $result; // Resultado de la consulta

        private function __clone() { } // El método __clone() se hace privado para evitar que se pueda clonar el objeto

        /**
         * Conectamos con el servidor de base de datos únicamente una vez
         * cuando creo la instancia de la clase Connection
         * @return PDO
         */
        private function __construct() { // El constructor se hace privado para que no se puedan crear instancias de la clase
            try {
                $dsn = "mysql:host=db;dbname=MeetoPlayDB";
                $username = "root";
                $password = "";

                $this->db = new PDO($dsn, $username, $password);
            } catch (PDOException $exp) {
                die("** Error al conectar: " . $exp->getMessage() . "<br/>");
            }
        }
        
        /**
         * Crea una única instancia de la conexión, la guarda y la devuelve
         * 
         * @return Connection
         */
        public static function getConnection(): Connection {
            if (self::$instance == null) { // Solo se crea la instancia si no existe

                // Creamos la instancia de la clase y conectamos a la base de datos
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
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $this->result = $stmt;

            return $this; // Devuelve el objeto Connection, por lo tanto puedo encadenar métodos
        }

            /**
             * Devuelve una sola fila de la consulta
             * @param string $class Nombre de la clase a la que se va a convertir el objeto
             * @return object
             */
            public function getRow(string $class): mixed {

                if ($this->result != null) {
                    $row = $this->result->fetchObject($class);
                    
                    if ($row == false) {
                        $this->result = null;
                    }
                    return $row;
                } else {
                    return null;
                }
            }

            /**
             * Cierra la conexión con la base de datos
             */
            public function close() {
                $this->db = null;
            }

            /**
             * Devuelve un array de objetos de la consulta
             * @param string $class Nombre de la clase a la que se va a convertir el objeto
             * @return array
             */
            public function getAll(string $class): array {
                $rows = array();

                while ($row = $this->getRow($class)) {
                    $rows[] = $row;
                }

                return $rows;
            }

            /**
             * Devuelve el último ID insertado
             * @return int
             */
            public function lastInsertId(): int {
                return $this->db->lastInsertId();
            }
        }

