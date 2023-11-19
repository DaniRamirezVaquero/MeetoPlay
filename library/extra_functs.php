<?php
/**
 * Función para redirigir a una URL
 * return
 */
function redireccion(String $url):never {
    exit(header("Location: $url"));
}

function echoPre ($algo) {
    echo "<pre>";
    echo print_r($algo);
    echo "</pre>";
    die();
}