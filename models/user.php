<?php

require_once $_SESSION['rootPath'] . "/library/connection.php";

class User
{

  public int $userId;
  public string $userName;
  public string $userStatus;
  public ?string $profilePic;
  public string $email;
  public string $password;
  public string $bornDate;

  public function __construct()
  {
  }

  public static function getAllUsers(): array
  {
    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Consulta a la base de datos, cogemos todos los users
    $db->query("SELECT * FROM user;");

    //Devolvemos los users
    return $db->getAll("user");
  }

  public static function getUserById(int $userId): User
  {
    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Consulta a la base de datos, cogemos la user que coincide con el ID pedido
    $db->query("SELECT * FROM user WHERE userId = $userId;");
    $user = $db->getRow("User"); //Devuelve un objeto user

    //Devolvemos la user
    return $user;
  }

  /**
   * Elimina un user de la base de datos
   * @return
   */
  public function delete()
  {
    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Consulta a la base de datos, borramos el user que coincide con el ID pedido
    $db->query("DELETE FROM user WHERE userId = $this->userId;");
  }

  public static function loginUser(string $email, string $password): mixed
  {
    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    $password = md5($password);

    // Consulta a la base de datos, cogemos la user que coincide con el email y la contraseña
    $db->query("SELECT * FROM user WHERE email = '$email' AND password = '$password';");
    $user = $db->getRow("User"); //Devuelve un objeto user

    //Devolvemos la user
    return $user;
  }

  public static function getUserByEmail(string $email): User
  {
    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Consulta a la base de datos, cogemos la user que coincide con el email pedido
    $db->query("SELECT * FROM user WHERE email = '$email';");
    $user = $db->getRow("User"); //Devuelve un objeto user

    //Devolvemos la user
    return $user;
  }

  public static function getAllFollowedUsers(int $userId): array
  {
    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Consulta a la base de datos, cogemos todos los usuarios seguidos por el usuario logeado
    $db->query("SELECT * FROM user WHERE userId IN (SELECT followedId FROM follower_followed WHERE followerId = " . $userId . ");");
    $followedUsers = $db->getAll("User"); //Devuelve array de users

    //Devolvemos los usuarios

    return $followedUsers;
  }

  /**
   * Devuelve todos los seguidores de un usuario
   * @param int $userId
   * @return array
   */
  public static function getAllFollowers(int $userId): array
  {
    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Consulta a la base de datos, cogemos todos los usuarios seguidos por el usuario logeado
    $db->query("SELECT * FROM user WHERE userId IN (SELECT followerId FROM follower_followed WHERE followedId = " . $userId . ");");
    $followers = $db->getAll("User"); //Devuelve un array de users

    //Devolvemos los usuarios
    return $followers;
  }

  /**
   * Devuelve los amigos de un usuario (seguidores al que el sigue también)
   * @param int $userId
   * @return array
   */
  public static function getAllFriends(int $userId): array
  {
    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Consulta a la base de datos, cogemos todos los usuarios seguidos por el usuario logeado
    $db->query("SELECT * FROM user WHERE userId IN (SELECT followerId FROM follower_followed WHERE followedId = " . $userId . ") AND userId IN (SELECT followedId FROM follower_followed WHERE followerId = " . $userId . ");");
    $friends = $db->getAll("User"); //Devuelve un array de users

    //Devolvemos los usuarios
    return $friends;
  }


  /**
   * Compueba si un email existe en la base de datos
   * @param string $email
   * @return bool
   */
  public static function emailExists(string $email): bool
  {
    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Consulta a la base de datos, cogemos la user que coincide con el email pedido
    $db->query("SELECT * FROM user WHERE email = '$email';");
    $user = $db->getRow("User"); //Devuelve un user

    //Devolvemos la user
    return $user != null;
  }

  /**
   * Compueba si un userName existe en la base de datos
   * @param string $userName
   * @return bool
   */
  public static function userNameExists(string $userName): bool
  {
    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Consulta a la base de datos, cogemos la user que coincide con el email pedido
    $db->query("SELECT * FROM user WHERE userName = '$userName';");
    $user = $db->getRow("User"); //Devuelve un objeto user

    //Devolvemos la user
    return $user != null;
  }

  /**
   * Guarda un user en la base de datos
   * @return
   */
  public function save()
  {
    // Establezco conexión con la base de datos
    $db = Connection::getConnection();

    // Consulta a la base de datos, insertamos el user
    $db->query("INSERT INTO user (userName, userStatus, profilePic, email, password, bornDate) VALUES ('$this->userName', '$this->userStatus', '$this->profilePic', '$this->email', '$this->password', '$this->bornDate');");
  }
}
