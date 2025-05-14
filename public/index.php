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

$dbConnection = DriverManager::getConnection($connectionParams, new Configuration());

$action = $_GET['action'] ?? 'list';

$controller = new Furka\WebtCoreDoctrineDbal\Controller\GameController($dbConnection);

switch ($action) {
    case 'list':
        $controller->list();
        break;
    case 'showAddForm':
        $controller->showAddForm();
        break;
    case 'add':
        $controller->add();
        break;
    case 'showDeleteForm':
        $controller->showDeleteForm();
        break;
    case 'delete':
        $controller->delete();
        break;
    default:
        $controller->list();
        break;
}