<?php

if (empty($_SESSION['loginstatus']) || $_SESSION['loginstatus'] !== 'loggedin') {
    header('Location: index.php?page=login');
    exit;
}

$model = new Pricing();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!Csrf::check($_POST['csrf'] ?? null)) {
        http_response_code(403);
        exit('Invalid request token');
    }

    if (!Role::can('manage_content')) {
        http_response_code(403);
        exit('Forbidden');
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $model->delete((int)($_POST['id'] ?? 0));
        header('Location: index.php?page=pricing');
        exit();
    }

    if ($action === 'create' || $action === 'update') {
        $name = trim($_POST['name'] ?? '');
        $price = $_POST['price'] ?? '';
        $billingPeriod = trim($_POST['billing_period'] ?? 'month');
        $tagline = trim($_POST['tagline'] ?? '');
        $features = trim($_POST['features'] ?? '');
        $isFeatured = !empty($_POST['is_featured']);
        $sortOrder = (int)($_POST['sort_order'] ?? 0);

        // Validation
        if ($name === '') {
            $errors['name'] = 'Name is required';
        }
        if (!is_numeric($price) || (float)$price < 0) {
            $errors['price'] = 'Enter a valid price (0 or more)';
        }

        if (empty($errors)) {
            if ($action === 'create') {
                $model->create($name, (float)$price, $billingPeriod, $tagline, $features, $isFeatured, $sortOrder);
            } else {
                $model->update((int)$_POST['id'], $name, (float)$price, $billingPeriod, $tagline, $features, $isFeatured, $sortOrder);
            }
            header('Location: index.php?page=pricing');
            exit;
        }
    }
}

$plans = $model->all();
$editing = isset($_GET['edit']) ? $model->find((int) $_GET['edit']) : null;