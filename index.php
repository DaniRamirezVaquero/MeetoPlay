<?php

require_once "library/extra_functs.php";
    //CONTROLADOR FRONTAL

    session_start(); // Inicio la sesión

    $_SESSION['rootPath'] = $_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF']);

    $model = $_GET["m"]??$_POST["m"]?? "user"; 
    $function = $_GET["f"]??$_POST["f"]?? "showLogin"; 
    //De manera predeterminada, si no se indica nada, se cargará el controller UsuarioController y la function showLogin

    $controllerName ="{$model}Controller"; // {Ejemplo}Controller

    // Ruta hasta el controller
    $path =  $_SESSION['rootPath']."/controllers/{$controllerName}.php"; // controllers/{ejemplo}Controller.php

    // Compruebo si existe el controller
    if (!file_exists($path)) die("**El controller {$controllerName} no existe");

    // Importamos el controller
    require_once $path;

    // Instanciamos el controller
    $controller = new $controllerName();

    // Ejecutamos la function del controller que nos ha llegado por la URL
    // Compruebo antes si existe la function en el controller
    if (method_exists($controller, $function)) $controller->$function();
    else  die("**La function {$function} no existe en el controlador {$controllerName}");
    
    