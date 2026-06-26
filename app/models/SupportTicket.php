<?php

class SupportTicket extends Model {

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM support_ticket ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare("
            INSERT INTO support_ticket (user_id, nama, email, pesan, status)
            VALUES (:user_id, :nama, :email, :pesan, 'Open')
        ");
        return $stmt->execute([
            ':user_id' => $data['user_id'],
            ':nama'    => $data['nama'],
            ':email'   => $data['email'],
            ':pesan'   => $data['pesan'],
        ]);
    }

    public function close(int $id): bool {
        $stmt = $this->db->prepare("UPDATE support_ticket SET status = 'Closed' WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getTotalOpen(): int {
        return (int) $this->db->query("SELECT COUNT(*) FROM support_ticket WHERE status = 'Open'")->fetchColumn();
    }
}
