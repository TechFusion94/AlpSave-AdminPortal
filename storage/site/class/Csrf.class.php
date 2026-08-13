<?php

class Csrf
{
    public static function token(): string
    {
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf'];
    }

    public static function check(?string $sent): bool
    {
        return is_string($sent) && hash_equals($_SESSION['csrf'] ?? '', $sent);
    }
}