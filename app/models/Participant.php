<?php
require_once __DIR__ . '/Model.php';

class Participant extends Model
{
    protected string $table = 'participants';

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

    public function byEvent(int $eventId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE event_id = :event ORDER BY id");
        $stmt->execute(['event' => $eventId]);
        return $stmt ? $stmt->fetchAll() : [];
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO `{$this->table}` (event_id, country_id, artist, song) VALUES (:event, :country, :artist, :song)");
        return $stmt->execute([
            'event' => $data['event_id'] ?? null,
            'country' => $data['country_id'] ?? null,
            'artist' => $data['artist'] ?? '',
            'song' => $data['song'] ?? '',
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['event_id'])) {
            $fields[] = 'event_id = :event';
            $params['event'] = $data['event_id'];
        }
        if (isset($data['country_id'])) {
            $fields[] = 'country_id = :country';
            $params['country'] = $data['country_id'];
        }
        if (isset($data['artist'])) {
            $fields[] = 'artist = :artist';
            $params['artist'] = $data['artist'];
        }
        if (isset($data['song'])) {
            $fields[] = 'song = :song';
            $params['song'] = $data['song'];
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

    public function getWithCountries(int $eventId): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                p.id,
                p.event_id,
                p.country_id,
                p.artist,
                p.song,
                c.name AS country_name
            FROM participants p
            LEFT JOIN countries c ON p.country_id = c.id
            WHERE p.event_id = :event
            ORDER BY c.name
        ");
        $stmt->execute(['event' => $eventId]);
        return $stmt ? $stmt->fetchAll() : [];
    }
}
