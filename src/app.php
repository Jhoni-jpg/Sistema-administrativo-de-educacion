<?php

require_once __DIR__ . '/../others/config/vistasPermitidas.php';

$viewValidation = new VistasPermitidas();

if (isset($_GET['view']) && $viewValidation->validacionVistas($_GET['view'])) {
    require __DIR__ . '/../views/' . $_GET['view'] . '.php';
} else {
    if ($_SERVER['REQUEST_URI'] == '/') {
        require __DIR__ . '/../views/login.php';
        exit;
    }
    require __DIR__ . '/../views/404.php';
}
