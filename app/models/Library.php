<?php

class Library extends Model {

    /**
     * Ambil semua game yang sudah dibeli user dari tabel library.
     * Setiap game dilengkapi dengan genre dan tanggal beli.
     */
    public function getByUser(int $userId): array {
        $stmt = $this->db->prepare("
            SELECT
                g.*,
                GROUP_CONCAT(gn.name SEPARATOR ', ') AS genres,
                o.created_at AS purchased_at
            FROM library l
            INNER JOIN game g         ON l.game_id  = g.id
            INNER JOIN `order` o      ON l.order_id = o.id
            LEFT  JOIN game_genre gg  ON g.id        = gg.game_id
            LEFT  JOIN genre gn       ON gg.genre_id = gn.id
            WHERE l.user_id = :user_id
            GROUP BY g.id, o.created_at
            ORDER BY l.created_at DESC
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }

    /**
     * Cek apakah user sudah punya game tertentu di library.
     */
    public function owns(int $userId, int $gameId): bool {
        $stmt = $this->db->prepare("
            SELECT id FROM library
            WHERE user_id = :user_id AND game_id = :game_id
            LIMIT 1
        ");
        $stmt->execute([':user_id' => $userId, ':game_id' => $gameId]);
        return $stmt->fetch() !== false;
    }

    /**
     * Tambah game ke library setelah pembayaran berhasil.
     */
    public function add(int $userId, int $gameId, int $orderId): bool {
        $stmt = $this->db->prepare("
            INSERT IGNORE INTO library (user_id, game_id, order_id)
            VALUES (:user_id, :game_id, :order_id)
        ");
        return $stmt->execute([
            ':user_id'  => $userId,
            ':game_id'  => $gameId,
            ':order_id' => $orderId,
        ]);
    }
}
