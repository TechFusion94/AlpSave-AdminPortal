<?php
require_once('config.php');
require_once('class/Csrf.class.php');
require_once('class/Database.class.php');
require_once('class/Pricing.class.php');
require_once('class/User.class.php');
require_once('class/Role.class.php');
require_once('class/Upload.class.php');
require_once('validate.php');
session_start();

// Default page
$page = 'login';
if (!empty($_GET['page'])) {
    $page = $_GET['page'];
}

$page = preg_replace('/[^a-z0-9_-]/', '', $page);

if ($page === '404' || !is_file("views/{$page}.php")) {
    http_response_code(404);
    $page = '404';
}

if (is_file("scripts/{$page}.php")) {
    include("scripts/{$page}.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlpSave</title>
    <link rel="icon" type="image/svg+xml" href="assets/images/alp-save-favicon.svg">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<img src="assets/images/alp-save-logo.png" alt="AlpSave" class="site-logo">

<?php
if (is_file("views/{$page}.php")) {
    include("views/{$page}.php");
}

?>

</body>
</html>
