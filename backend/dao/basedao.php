<?php
abstract class BaseDao {
    protected PDO $db;
    protected string $table;
    protected array $fields;

    public function __construct(PDO $db) { $this->db = $db; }

    public function getAll(): array {
        return $this->db->query("SELECT * FROM {$this->table} ORDER BY id")->fetchAll();
    }
    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }
    protected function filtered(array $data): array {
        return array_intersect_key($data, array_flip($this->fields));
    }
    public function create(array $data): int {
        $data = $this->filtered($data);
        if (!$data) throw new InvalidArgumentException('No valid fields provided');
        $columns = array_keys($data);
        $names = implode(', ', $columns);
        $placeholders = implode(', ', array_map(fn($c) => ':' . $c, $columns));
        $stmt = $this->db->prepare("INSERT INTO {$this->table} ($names) VALUES ($placeholders)");
        $stmt->execute($data);
        return (int)$this->db->lastInsertId();
    }
    public function update(int $id, array $data): bool {
        $data = $this->filtered($data);
        if (!$data) throw new InvalidArgumentException('No valid fields provided');
        $sets = implode(', ', array_map(fn($c) => "$c = :$c", array_keys($data)));
        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE {$this->table} SET $sets WHERE id = :id");
        $stmt->execute($data);
        return $this->getById($id) !== null;
    }
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
