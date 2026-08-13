<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !Csrf::check($_POST['csrf'] ?? null)) {
    http_response_code(403);
    exit('Invalid request token');
}

if (empty($_SESSION['loginstatus']) || $_SESSION['loginstatus'] !== 'loggedin') {
    header('Location: index.php?page=login');
    exit;
}

if (isset($_POST['action']) && $_POST['action'] === 'logout') {
    session_destroy();
    header('Location: index.php?page=login');
    exit;
}

$totalUsers   = (new User())->count();
$totalUploads = (new Upload())->count();
$totalPlans   = (new Pricing())->count();
$recentUsers  = (new User())->recent(5);