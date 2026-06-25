<?php

class SupportTicket extends Model {

    /**
     * Simpan tiket bantuan baru ke database.
     * user_id boleh NULL (tamu yang belum login tetap bisa mengirim tiket).
     *
     * @param array{user_id:?int, nama:string, email:string, pesan:string} $data
     */
    public function create(array $data): bool {
        $stmt = $this->db->prepare("
            INSERT INTO support_ticket (user_id, nama, email, pesan)
            VALUES (:user_id, :nama, :email, :pesan)
        ");
        return $stmt->execute([
            ':user_id' => $data['user_id'],
            ':nama'    => $data['nama'],
            ':email'   => $data['email'],
            ':pesan'   => $data['pesan'],
        ]);
    }

    /**
     * Ambil riwayat tiket milik satu user (untuk halaman "Riwayat Tiket Saya", jika dibutuhkan nanti).
     */
    public function getByUser(int $userId): array {
        $stmt = $this->db->prepare("
            SELECT * FROM support_ticket
            WHERE user_id = :user_id
            ORDER BY created_at DESC
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }
}
