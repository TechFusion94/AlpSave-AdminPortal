<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!Csrf::check($_POST['csrf'] ?? null)) {
        http_response_code(403);
        exit('Invalid request token');
    }

    $userModel = new User();
    $user = $userModel->findByUsername(trim($_POST['username'] ?? ''));

    if ($user && password_verify($_POST['password'] ?? '', $user['password'])) {
        session_regenerate_id(true);

        $_SESSION['loginstatus'] = 'loggedin';
        $_SESSION['userid'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['avatar'] = $user['avatar'];
        $_SESSION['login_time'] = time();
        header('Location: index.php?page=dashboard');
        exit;
    }

    $errors['login'] = 'Invalid username or password';

}