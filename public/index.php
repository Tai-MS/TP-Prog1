<?php

// Ruta hacia las vistas
$viewPath = '../src/views/';

// Obtener la página solicitada (por ejemplo, a través de una query string)
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Validar la página solicitada
switch ($page) {
    case 'home':
        include $viewPath . 'home.html';
        break;
    case 'about':
        include $viewPath . 'about.html';
        break;
    case 'contact':
        include $viewPath . 'contact.html';
        break;
    default:
        // Página por defecto o error 404
        echo "Page not found.";
        break;
}

