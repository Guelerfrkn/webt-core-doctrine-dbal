<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration;

require __DIR__ . '/../vendor/autoload.php';

$connectionParams = [
    'dbname'   => 'usarps_stats',
    'user'     => 'root',
    'password' => '',
    'host'     => 'localhost',
    'driver'   => 'pdo_mysql',
    'charset'  => 'utf8mb4'
];

$config = new Configuration();
$dbConnection = null;

try {
    $dbConnection = DriverManager::getConnection($connectionParams, $config);
} catch (\Doctrine\DBAL\Exception $e) {
    die("Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}

// Einfaches Routing basierend auf einem 'action'-Parameter
$action = $_GET['action'] ?? 'list'; // Standardaktion ist 'list'

// Controller instanziieren
$controller = new Furka\WebtCoreDoctrineDbal\Controller\GameController($dbConnection);

// Gewünschte Methode im Controller aufrufen
switch ($action) {
    case 'list':
        $controller->list();
        break;
    case 'showAddForm':
        $controller->showAddForm();
        break;
    case 'add':
        $controller->add(); // Verarbeitet POST-Daten vom Formular
        break;
    case 'showDeleteForm':
        $controller->showDeleteForm();
        break;
    case 'delete':
        $controller->delete(); // Verarbeitet POST vom Löschen-Formular
        break;
    default:
        // Einfache 404-Seite oder Weiterleitung zur Liste
        http_response_code(404);
        echo "Seite nicht gefunden (Ungültige Aktion: " . htmlspecialchars($action) . ")";
        // Alternativ: $controller->list();
        break;
}