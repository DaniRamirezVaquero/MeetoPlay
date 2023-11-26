<?php

require_once "vendor/autoload.php";
require_once "library/TwigFunctions.php";

abstract class Controller {

    private $twig;

    /**
     * Constructor
     */
    public function __construct() { 

        //Configuramosla librería Twig indicandole la ruta hasta la view
        // Cargamos el directorio de plantillas
        $loader = new \Twig\Loader\FilesystemLoader("views");
        $this->twig = new \Twig\Environment($loader);

        //Añado funciones personalizadas a Twig
        $this->twig->addFunction(new \Twig\TwigFunction('UserJoinedEvent', 'UserJoinedEvent'));

    }

    /**
     * Este método se encarga de renderizar una view
     * @param string $view
     * @param array $datos
     * @return
     */
    public function render ($view, $datos = []) {
        echo $this->twig->render($view, $datos);
    }
}