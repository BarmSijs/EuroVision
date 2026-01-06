<?php
require_once __DIR__ . '/Model.php';

class Score extends Model
{
    protected string $table = 'scores';

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

    public function findByUserAndParticipant(int $userId, int $participantId): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE user_id = :user AND participant_id = :participant LIMIT 1");
        $stmt->execute(['user' => $userId, 'participant' => $participantId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO `{$this->table}` (user_id, participant_id, song_score, outfit_score, act_score, total_score) VALUES (:user, :participant, :song, :outfit, :act, :total)");
        return $stmt->execute([
            'user' => $data['user_id'] ?? null,
            'participant' => $data['participant_id'] ?? null,
            'song' => $data['song_score'] ?? 0,
            'outfit' => $data['outfit_score'] ?? 0,
            'act' => $data['act_score'] ?? 0,
            'total' => $data['total_score'] ?? 0,
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['song_score'])) { $fields[] = 'song_score = :song'; $params['song'] = $data['song_score']; }
        if (isset($data['outfit_score'])) { $fields[] = 'outfit_score = :outfit'; $params['outfit'] = $data['outfit_score']; }
        if (isset($data['act_score'])) { $fields[] = 'act_score = :act'; $params['act'] = $data['act_score']; }
        if (isset($data['total_score'])) { $fields[] = 'total_score = :total'; $params['total'] = $data['total_score']; }

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
}
