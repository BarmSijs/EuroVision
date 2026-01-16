<?php
require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/Participant.php';

class Event extends Model
{
    protected string $table = 'events';

    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM `{$this->table}` ORDER BY year DESC");
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
        $stmt = $this->db->prepare("INSERT INTO `{$this->table}` (year, name, winner_participant_id) VALUES (:year, :name, :winner)");
        return $stmt->execute([
            'year' => $data['year'] ?? null,
            'name' => $data['name'] ?? '',
            'winner' => $data['winner_participant_id'] ?? null,
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['year'])) {
            $fields[] = 'year = :year';
            $params['year'] = $data['year'];
        }
        if (isset($data['name'])) {
            $fields[] = 'name = :name';
            $params['name'] = $data['name'];
        }
        if (array_key_exists('winner_participant_id', $data)) {
            $fields[] = 'winner_participant_id = :winner';
            $params['winner'] = $data['winner_participant_id'];
        }

        if (empty($fields)) return false;

        $sql = "UPDATE `{$this->table}` SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM `{$this->table}` WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function participants(int $eventId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM participants WHERE event_id = :event ORDER BY id");
        $stmt->execute(['event' => $eventId]);
        return $stmt ? $stmt->fetchAll() : [];
    }

    public function winnerEvent(int $eventId): array
    {
        $stmt = $this->db->prepare("SELECT
            e.year,
            e.name AS event_name,
            p.artist,
            p.song
            FROM events e
            LEFT JOIN participants p
            ON e.winner_participant_id = p.id
            WHERE e.id = :event LIMIT 1");
        $stmt->execute(['event' => $eventId]);
        $row = $stmt->fetch();
        return $row ?: [];
    }

}
