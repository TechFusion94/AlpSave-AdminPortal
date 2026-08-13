<?php

if (empty($_SESSION['loginstatus']) || $_SESSION['loginstatus'] !== 'loggedin') {
    header('Location: index.php?page=login');
    exit;
}

if (!Role::can('manage_users')) {
   header('Location: index.php?page=dashboard');
   exit;
}

$model = new User();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!Csrf::check($_POST['csrf'] ?? null)) {
        http_response_code(403);
        exit('Invalid request token');
    }

    $action = $_POST['action'] ?? '';
    $id = (int) ($_POST['id'] ?? 0);

    if ($action === 'delete') {
        if ($id === (int) ($_SESSION['userid'] ?? 0)) {
            $errors['general'] = "You can't delete your own account.";
        } else {
            $model->delete($id);
            header('Location: index.php?page=users');
            exit;
        }
    }

    if ($action === 'update_role') {
        $role = $_POST['role'] ?? '';
        $validRoles = ['super_admin', 'admin', 'data_manager', 'read_only'];

        if (!in_array($role, $validRoles, true)) {
            $errors['general'] = 'Please select a valid role.';
        } else {
            $model->updateRole($id, $role);
            header('Location: index.php?page=users');
            exit;
        }
    }
}

$users = $model->all();