<?php

/**
 * Función para redirigir a una URL
 * return
 */
function redireccion(String $url): never
{
  exit(header("Location: $url"));
}

function echoPre(mixed $algo, bool $die = false)
{
  echo "<pre>";
  echo print_r($algo);
  echo "</pre>";
  if ($die) die();
}

/**
 * Función para comprabar si el usuario ha iniciado sesión
 * @return
 */
function checkSession()
{
  if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
    // Si el usuario ya ha iniciado sesión, redirígelo a la página de inicio
    redireccion("/main");
  }
}

/**
 * Comprueba si se está queriendo acceder a algun recurso de manera ilegal
 * @return
 */
function checkAccess() {
  if (!isset($_SESSION["loggedIn"])) {
    redireccion("/login");
  }
}

/**
 * Formatea la fecha y la hora de un grupo de eventos para que se muestre correctamente
 * @param array $events
 * @return array
 */
function formatEventsDateTime(array $events): array
{
  foreach ($events as $event) {
    $event->dateBegin = $event->formatDate($event->dateBegin);
    $event->dateEnd = $event->formatDate($event->dateEnd);
    $event->hourBegin = $event->formatHour($event->hourBegin);
    $event->hourEnd = $event->formatHour($event->hourEnd);
    $event->dateInscriptionEnd = $event->formatDate($event->dateInscriptionEnd);
    $event->hourInscriptionEnd = $event->formatHour($event->hourInscriptionEnd);
  }
  return $events;
}
