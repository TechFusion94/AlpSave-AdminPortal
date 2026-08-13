<?php

// Check that all required fields are present and non-empty.
function validateRequired(array $fields, array $data): array {
    $missing = [];
    foreach ($fields as $field) {
        if (!isset($data[$field]) || trim($data[$field]) === '') {
            $missing[] = $field;
        }
    }
    return $missing;
}

//Check that an email address is valid.
function validateEmail(string $email): bool {
    return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
}

//Check that a password meets the rules defined in config.php.
function validatePassword(string $password): bool
{
    if (str_contains($password, ' '))
        return false;
    if (strlen($password) < MIN_PW_LENGTH)
        return false;
    if (preg_match_all('/[A-Z]/', $password) < MIN_UPPER)
        return false;
    if (preg_match_all('/[a-z]/', $password) < MIN_LOWER)
        return false;
    if (preg_match_all('/[0-9]/', $password) < MIN_DIGITS)
        return false;
    if (preg_match_all('/[^A-Za-z0-9]/', $password) < MIN_SPECIAL)
        return false;
    return true;
}