<?php
include 'includes/cookies.php';
include 'includes/header.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'sobre':
        include 'pages/sobre.php';
        break;
    case 'ouvidoria':
        include 'pages/ouvidoria.php';
        break;
    case 'segmentos':
        include 'pages/segmentos.php';
        break;
            case 'aplicativos':
        include 'pages/aplicativos.php';
        break;

    default:
        include 'pages/home.php';
        break;
}

include 'includes/footer.php';
?>