<?php
/**
 * Función para redirigir a una URL
 * return
 */
function redireccion(String $url):never {
    exit(header("Location: $url"));
}

function echoPre (mixed $algo, bool $die = false) {
    echo "<pre>";
    echo print_r($algo);
    echo "</pre>";
    if($die) die();
}

/**
 * Función para comprabar si el usuario ha iniciado sesión
 * @return
 */
function checkSession ():void {
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
        // Si el usuario ya ha iniciado sesión, redirígelo a la página de inicio
        redireccion("main");
    }
}