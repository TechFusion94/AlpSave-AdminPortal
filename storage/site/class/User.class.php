<?php

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare('SELECT id, username, password, role, avatar FROM users WHERE username = ?');
        $stmt->execute([$username]);

        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function existsByUsername(string $username): bool
    {
        $stmt = $this->db->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->execute([$username]);
        return (bool) $stmt->fetch();
    }

    public function create(
        string $username,
        string $email,
        string $hashedPassword,
        string $role,
        string $department,
        bool $terms,
        bool $notifications,
        ?string $avatar = null
    ): void
    {

        $stmt = $this->db->prepare(
            'INSERT INTO users (username, email, password, role, department, terms, notifications, avatar)
     VALUES (:username, :email, :password, :role, :department, :terms, :notifications, :avatar)'
        );
        $stmt->execute([
            'username'      => $username,
            'email'         => $email,
            'password'      => $hashedPassword,
            'role'          => $role,
            'department'    => $department,
            'terms'         => (int) $terms,
            'notifications' => (int) $notifications,
            'avatar' => $avatar,
        ]);
    }

    public function existsByEmail(string $email): bool
    {
        $stmt = $this->db->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return (bool) $stmt->fetch();
    }

    public function recent(int $limit = 5): array
    {
        $stmt = $this->db->prepare(
            'SELECT id, username, email, role, avatar, created_at
         FROM users ORDER BY created_at DESC LIMIT :limit'
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function all(): array
    {
        $stmt = $this->db->query(
            'SELECT id, username, email, role, department, created_at FROM users ORDER BY created_at DESC'
        );
        return $stmt->fetchAll();
    }

    public function updateRole(int $id, string $role): void
    {
        $stmt = $this->db->prepare('UPDATE users SET role = :role WHERE id = :id');
        $stmt->execute([
            'role' => $role,
            'id' => $id,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }

}