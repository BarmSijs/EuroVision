<?php
require_once __DIR__ . '/Model.php';

class Countrie extends Model
{
    protected string $table = 'countries';

    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM `{$this->table}` ORDER BY id DESC");
        return $stmt ? $stmt->fetchAll() : [];
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO `{$this->table}` (name, price, description) VALUES (:name, :price, :description)");
        return $stmt->execute([
            'name' => $data['name'] ?? '',
            'price' => $data['price'] ?? 0,
            'description' => $data['description'] ?? null,
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("UPDATE `{$this->table}` SET name = :name, price = :price, description = :description WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'] ?? '',
            'price' => $data['price'] ?? 0,
            'description' => $data['description'] ?? null,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM `{$this->table}` WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
