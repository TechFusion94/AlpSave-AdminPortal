<?php

class Role
{
    private const CAPABILITIES = [
        'super_admin' => ['manage_users', 'manage_content'],
        'admin' => ['manage_content'],
        'data_manager' => ['manage_content'],
        'read_only' => [],
    ];

    public static function can(string $capability, ?string $role = null): bool
    {
        $role ??= $_SESSION['role'] ?? '';
        return in_array($capability, self::CAPABILITIES[$role] ?? [], true);
    }
}