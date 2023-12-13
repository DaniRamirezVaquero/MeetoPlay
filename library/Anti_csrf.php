<?php

class Anti_csrf
{

  private static ?Anti_csrf $instance = null; // '?Anti_csrf' indica que puede ser null
  private $token; // Token de seguridad

  private function __clone()
  {
  } // El método __clone() se hace privado para evitar que se pueda clonar el objeto

  /**
   * Crea una unica instacia de la conexion, la guarda y la devuelve
   * 
   * @return Anti_csrf
   */
  public static function getAnti_csrf(): Anti_csrf
  {
    if (self::$instance == null) { // Solo se crea la instance si no existe

      // Cremos la instancia de la clase y conectamos a la base de datos
      self::$instance = new Anti_csrf();
    }

    return self::$instance;
  }

  /**
   * Devuelve el token de seguridad
   * 
   * @return string
   */
  public function getToken(): string
  {
    return $this->token;
  }

  /**
   * Genera un token de seguridad
   * 
   * @return string
   */
  public function generateToken()
  {
    $this->token = md5(uniqid(mt_rand())); // Genero un token aleatorio y lo encripto
    $_SESSION["_csrf"] = $this->token; // Guardo el token en la sesión
    return $this->token;
  }

  /**
   * Comprueba si el token de seguridad es correcto
   * 
   * @param string $token
   * @return bool
   */
  public function checkToken(string $token): bool
  {
    return $this->token === $token;
  }
}
