<?php

class Upload
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM uploads')->fetchColumn();
    }

    public function create(string $path, string $alt): void
    {
        $stmt = $this->db->prepare('INSERT INTO uploads (path, alt) VALUES (?, ?)');
        $stmt->execute([$path, $alt]);
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM uploads ORDER BY id DESC');
        return $stmt->fetchAll();
    }
}