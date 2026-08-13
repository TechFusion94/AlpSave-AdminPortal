<?php

require_once('class/FileUpload.class.php');

if (empty($_SESSION['loginstatus']) || $_SESSION['loginstatus'] !== 'loggedin' || !Role::can('manage_users')) {
    header('Location: index.php?page=login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!Csrf::check($_POST['csrf'] ?? null)) {
            http_response_code(403);
            exit('Invalid request token');
        }

        $action = $_POST['action'] ?? '';
        $step = $_SESSION['register_step'] ?? 1;

        $userModel = new User();

        // Back button
    if ($action === 'back') {
        $_SESSION['register_step']--;
        return;
    }

    if ($action === 'restart') {
        $_SESSION['register_step'] = 1;
        $_SESSION['register_data'] = [];
        return;
    }

    if ($step === 1) {
        // Validate the form data
        $_SESSION['register_data'] = [
            'username' => strip_tags(trim($_POST['username'] ?? '')),
            'email'    => strip_tags(trim($_POST['email'] ?? '')),
        ];

        // Check required fields
        $missing = validateRequired(['username', 'email', 'password', 'password_confirm'], $_POST);
        foreach ($missing as $field) {
            $errors[$field] = 'This field is required';
        }

        // Check username
        if (empty($errors['username'])) {
            $u = $_SESSION['register_data']['username'];
            if (strlen($u) < 4 || strlen($u) > 16)
                $errors['username'] = 'Username must be between 4 and 16 characters';
            elseif (str_contains($u, ' '))
                $errors['username'] = 'Username cannot contain spaces';
        }

        // Check username is not taken
        if (empty($errors['username']) && $userModel->existsByUsername($_SESSION['register_data']['username'])) {
            $errors['username'] = 'This username is already taken';
        }

        // Check email format
        if (empty($errors['email']) && !validateEmail($_POST['email'])) {
            $errors['email'] = 'Please enter a valid email address';
        }

        // Check email is not taken
        if (empty($errors['email']) && $userModel->existsByEmail($_SESSION['register_data']['email'])) {
            $errors['email'] = 'This email address is already registered';
        }

        // Check password
        if (empty($errors['password']) && !validatePassword($_POST['password'])) {
            $errors ['password'] = 'Password must contain at least 8 characters, including uppercase, lowercase, numbers, and special characters';
        }

        // Check password match
        if (empty($errors['password_confirm']) && $_POST['password'] !== $_POST['password_confirm']) {
            $errors['password_confirm'] = 'Passwords do not match';
        }

        // Advance if no errors
        if (empty($errors)) {
            $_SESSION['register_data']['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $_SESSION['register_step'] = 2;
            return;
        }
    }

    if ($step === 2) {
        $_SESSION['register_data']['role'] = $_POST['role'] ?? '';
        $_SESSION['register_data']['department'] = $_POST['department'] ?? '';

        // Check required fields
        $missing = validateRequired(['role', 'department'], $_POST);
        foreach ($missing as $field) {
            $errors[$field] = 'Please make a selection';
        }

        // Check if role is a valid option
        $validRoles = ['super_admin', 'admin', 'data_manager', 'read_only'];
        if (empty($errors['role']) && !in_array($_POST['role'] ?? '', $validRoles)) {
            $errors['role'] = 'Please select a valid role';
        }

        // Check if department is a valid option
        $validDepts = ['finance', 'engineering', 'operations', 'hr', 'marketing'];
        if (empty($errors['department']) && !in_array($_POST['department'] ?? '', $validDepts)) {
            $errors['department'] = 'Please select a valid department';
        }

        // Advance if no errors
        if (empty($errors)) {
            $_SESSION['register_step'] = 3;
            return;
        }
    }

    if ($step === 3) {
        // Sticky fields
        $_SESSION['register_data']['terms']         = $_POST['terms']         ?? '';
        $_SESSION['register_data']['notifications'] = $_POST['notifications'] ?? '';

        // Terms must be accepted
        if (empty($_POST['terms'])) {
            $errors['terms'] = 'You must accept the Terms of Service.';
        }

        // Avatar upload — optional
        $avatar = null;
        if (!empty($_FILES['photo']['name'])) {
            $avatar = new FileUpload('photo', 2 * 1024 * 1024);
            if (!($avatar->checkFileError() && $avatar->checkFileType() && $avatar->checkFileSize())) {
                $errors['photo'] = $avatar->errors[0] ?? 'Avatar upload failed.';
            }
        }

        if (empty($errors)) {
            $avatarPath = ($avatar && $avatar->moveFile()) ? $avatar->getFinalPath() : null;

            $data = $_SESSION['register_data'];
            $userModel->create(
                $data['username'], $data['email'], $data['password'],
                $data['role'], $data['department'],
                !empty($data['terms']), !empty($data['notifications']),
                $avatarPath
            );

            $_SESSION['register_step'] = 4;
            $_SESSION['register_data'] = [];
            return;
        }

    }

} else {
    // Initialize the registration process
    $_SESSION['register_step'] = $_SESSION['register_step'] ?? 1;
}