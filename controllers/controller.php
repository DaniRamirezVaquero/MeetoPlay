<?php

require_once $_SESSION['rootPath'] . "/vendor/autoload.php";
require_once $_SESSION['rootPath'] . "/library/TwigFunctions.php";

abstract class Controller
{

  private $twig;

  /**
   * Constructor
   */
  public function __construct()
  {

    // Configuramosla librería Twig indicandole la ruta hasta la view
    // Cargamos el directorio de plantillas
    $loader = new \Twig\Loader\FilesystemLoader($_SESSION['rootPath'] . "/views");
    $this->twig = new \Twig\Environment($loader, ["debug" => true]);

    // Añado funciones personalizadas a Twig
    $this->twig->addFunction(new \Twig\TwigFunction('UserJoinedEvent', 'UserJoinedEvent'));
    $this->twig->addExtension(new \Twig\Extension\DebugExtension());
  }

  /**
   * Este método se encarga de renderizar una view
   * @param string $view
   * @param array $datos
   * @return
   */
  public function render(string $view, array $datos = [])
  {
    echo $this->twig->render($view, $datos);
  }
}
