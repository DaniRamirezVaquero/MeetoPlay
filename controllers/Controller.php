<?php

require_once "vendor/autoload.php";

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