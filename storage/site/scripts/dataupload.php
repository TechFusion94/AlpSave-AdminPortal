<?php

require_once('class/FileUpload.class.php');

// Logged-in + content-manager only
if (empty($_SESSION['loginstatus']) || $_SESSION['loginstatus'] !== 'loggedin') {
    header('Location: index.php?page=login');
    exit;
}
if (!Role::can('manage_content')) {
    header('Location: index.php?page=dashboard');
    exit;
}

$uploadErrors  = [];
$uploadSuccess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::check($_POST['csrf'] ?? null)) {
        http_response_code(403);
        exit('Invalid request token');
    }

    $uploader = new FileUpload();

    if ($uploader->checkFileError()
        && $uploader->checkFileType()
        && $uploader->checkFileSize()
        && $uploader->validateAltText($_POST['alt'] ?? '')
        && $uploader->moveFile()) {
        (new Upload())->create($uploader->getFinalPath(), trim($_POST['alt']));
        $uploadSuccess = 'File uploaded successfully!';
    }

    $uploadErrors = $uploader->errors;
}

$uploads = (new Upload())->all();