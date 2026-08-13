<?php

class FileUpload {
    private $uploadBaseDir = 'uploads/';
    private $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    private $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    private string $field;
    private int $maxFileSize;
    private $finalPath = '';
    public $errors = [];

    public function __construct(string $field = 'file', int $maxFileSize = 5242880)
    {
        $this->field = $field;
        $this->maxFileSize = $maxFileSize;
    }


    public function checkFileError(): bool {
        $errorNo = $_FILES[$this->field]['error'];
        switch ($errorNo) {
            case 0:
                break;
            case 1:
                $this->errors[] = "The image is too big (Error 1).";
                break;
            case 2:
                $this->errors[] = "The image is too big (Error 2).";
                break;
            case 3:
                $this->errors[] = "The image was only partially uploaded. Please check your internet connection (Error 3).";
                break;
            case 4:
                $this->errors[] = "No file has been uploaded. Please select an image before clicking the upload button (Error 4).";
                break;
            case 6:
                $this->errors[] = "An error occurred while saving the image to the server. Please contact the web developer (Error 6).";
                break;
            case 7:
                $this->errors[] = "An error occurred while saving the image to the server. Please contact the web developer (Error 7).";
                break;
            case 8:
                $this->errors[] = "An error occurred while saving the image to the server. Please contact the web developer (Error 8).";
                break;
        }

        return $errorNo === 0;
    }

    public function checkFileType(): bool {
        $hasErrors = false;

        $ext = strtolower(pathinfo($_FILES[$this->field]['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $this->allowedExtensions)) {
            $hasErrors = true;
            $this->errors[] = "The image format is invalid.";
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($_FILES[$this->field]['tmp_name']);
        if (!in_array($mime, $this->allowedMimeTypes)) {
            $hasErrors = true;
            $this->errors[] = "The image format is invalid.";
        }

        return !$hasErrors;
    }

    public function checkFileSize(): bool {
        if ($_FILES[$this->field]['size'] > $this->maxFileSize) {
            $this->errors[] = "File is too large. Maximum size is " . round($this->maxFileSize / 1048576) . "MB.";
            return false;
        }
        return true;
    }

    public function validateAltText(string $alt): bool {
        $hasErrors = false;

        if (trim($alt) == '') {
            $hasErrors = true;
            $this->errors[] = "Alt text is required.";
        }

        if (strlen(trim($alt)) > 255) {
            $hasErrors = true;
            $this->errors[] = "Alt text may not exceed 255 characters.";
        }

        return !$hasErrors;
    }

    private function buildDatePath(): string {
        $datePath = $this->uploadBaseDir . date('Y/m/d') . '/';
        if (!is_dir($datePath)) {
            mkdir($datePath, 0755, true);
        }
        return $datePath;
    }

    private function buildUniqueFilename(): string {
        $ext = strtolower(pathinfo($_FILES[$this->field]['name'], PATHINFO_EXTENSION));
        return uniqid() . '.' . $ext;
    }

    public function moveFile(): bool {
        $datePath = $this->buildDatePath();
        $filename = $this->buildUniqueFilename();
        $destination = $datePath . $filename;

        if (move_uploaded_file($_FILES[$this->field]['tmp_name'], $destination)) {
            $this->finalPath = $destination;
            return true;
        }

        $this->errors[] = "File could not be moved.";
        return false;
    }

    public function getFinalPath(): string {
        return $this->finalPath;
    }

}

