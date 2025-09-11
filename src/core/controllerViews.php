<?php

require_once __DIR__ . '/../../others/config/vistasPermitidas.php';

$viewValidation = new VistasPermitidas();

if (isset($_GET['view']) && $viewValidation->validacionVistas($_GET['view'])) {
    $controllerFile = __DIR__ . '/../../views/' . $_GET['view'] . '.php';

    if (file_exists($controllerFile)) {
        require_once __DIR__ . '/../../views/' . $_GET['view'] . '.php';
    }
} else {
    if ($_SERVER['REQUEST_URI'] == '/') {
        require_once __DIR__ . '/../../views/login.php';
        exit;
    }

    if (isset($_GET['url'])) {
        exit;
    }
    
    require_once __DIR__ . '/../../views/404.php';
}
