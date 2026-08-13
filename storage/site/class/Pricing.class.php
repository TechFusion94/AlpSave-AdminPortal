<?php

class Pricing
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM pricing_plans')->fetchColumn();
    }

    public function all():array
    {
        $stmt = $this->db->query('SELECT * FROM pricing_plans ORDER BY sort_order');
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM pricing_plans WHERE id = ?');
        $stmt->execute([$id]);
        $plan = $stmt->fetch();
        return $plan ?: null;
    }

    public function create(string $name, float $price, string $billingPeriod, string $tagline, string $features, bool $isFeatured, int $sortOrder): void
    {

        $stmt = $this->db->prepare('INSERT INTO pricing_plans (name, price, billing_period, tagline, features, is_featured, sort_order) VALUES (:name, :price, :billing_period, :tagline, :features, :is_featured, :sort_order)'
        );
        $stmt->execute([
            'name'           => $name,
            'price'          => $price,
            'billing_period' => $billingPeriod,
            'tagline'        => $tagline,
            'features'       => $features,
            'is_featured'    => (int) $isFeatured,
            'sort_order'     => $sortOrder,
        ]);
    }

    public function update(int $id, string $name, float $price, string $billingPeriod,
                           string $tagline, string $features, bool $isFeatured, int $sortOrder): void
    {
        $stmt = $this->db->prepare(
            'UPDATE pricing_plans
            SET name = :name, price = :price, billing_period = :billing_period,
                tagline = :tagline, features = :features,
                is_featured = :is_featured, sort_order = :sort_order
          WHERE id = :id'
        );
        $stmt->execute([
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'billing_period' => $billingPeriod,
            'tagline' => $tagline,
            'features' => $features,
            'is_featured' => (int)$isFeatured,
            'sort_order' => $sortOrder,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM pricing_plans WHERE id = ?');
        $stmt->execute([$id]);
    }
}