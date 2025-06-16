<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/ArticleController.php';

$pdo = connectDB();
$controller = new ArticleController($pdo);

$page = $_GET['page'] ?? 'articles';
$action = $_GET['action'] ?? 'index';

if ($page === 'articles') {
    if ($action === 'store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->store();
    } elseif ($action === 'ajouter') {
        $controller->ajouter();
    } else {
        $controller->index();
    }
} else {
    echo "Page non trouvée";
}
