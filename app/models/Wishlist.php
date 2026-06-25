<?php

class Wishlist extends Model {

    /**
     * Cek apakah game sudah ada di wishlist user.
     */
    public function isWishlisted(int $userId, int $gameId): bool {
        $stmt = $this->db->prepare("
            SELECT id FROM wishlist
            WHERE user_id = :user_id AND game_id = :game_id
            LIMIT 1
        ");
        $stmt->execute([
            ':user_id' => $userId,
            ':game_id' => $gameId,
        ]);
        return $stmt->fetch() !== false;
    }

    /**
     * Ambil semua game_id yang ada di wishlist user — lebih efisien
     * daripada query satu per satu di dalam loop.
     */
    public function getGameIdsByUser(int $userId): array {
        $stmt = $this->db->prepare("
            SELECT game_id FROM wishlist
            WHERE user_id = :user_id
        ");
        $stmt->execute([':user_id' => $userId]);
        return array_column($stmt->fetchAll(), 'game_id');
    }

    /**
     * Ambil seluruh game di wishlist user beserta genre-nya (GROUP_CONCAT).
     * Game yang sudah dimiliki (sudah ada di Library) otomatis disembunyikan,
     * karena tujuannya sudah tercapai (sudah dibeli) — sama seperti behavior
     * pada wishlist.php versi lama.
     */
    public function getByUser(int $userId): array {
        $stmt = $this->db->prepare("
            SELECT
                g.*,
                GROUP_CONCAT(gn.name SEPARATOR ', ') AS genres,
                w.created_at AS wishlisted_at
            FROM wishlist w
            INNER JOIN game g         ON w.game_id  = g.id
            LEFT  JOIN game_genre gg  ON g.id        = gg.game_id
            LEFT  JOIN genre gn       ON gg.genre_id = gn.id
            WHERE w.user_id = :user_id
            AND NOT EXISTS (
                SELECT 1 FROM library l
                WHERE l.user_id = w.user_id AND l.game_id = w.game_id
            )
            GROUP BY g.id, w.created_at
            ORDER BY w.id DESC
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }

    /**
     * Tambah game ke wishlist. INSERT IGNORE supaya aman dari duplikat
     * (kombinasi user_id + game_id sudah UNIQUE KEY di database).
     */
    public function add(int $userId, int $gameId): bool {
        $stmt = $this->db->prepare("
            INSERT IGNORE INTO wishlist (user_id, game_id)
            VALUES (:user_id, :game_id)
        ");
        return $stmt->execute([
            ':user_id' => $userId,
            ':game_id' => $gameId,
        ]);
    }

    /**
     * Hapus game dari wishlist user.
     */
    public function remove(int $userId, int $gameId): bool {
        $stmt = $this->db->prepare("
            DELETE FROM wishlist
            WHERE user_id = :user_id AND game_id = :game_id
        ");
        return $stmt->execute([
            ':user_id' => $userId,
            ':game_id' => $gameId,
        ]);
    }

    /**
     * Toggle wishlist: tambah jika belum ada, hapus jika sudah ada.
     * Mengembalikan 'added' atau 'removed' agar Controller bisa
     * menyesuaikan pesan toast.
     */
    public function toggle(int $userId, int $gameId): string {
        if ($this->isWishlisted($userId, $gameId)) {
            $this->remove($userId, $gameId);
            return 'removed';
        }

        $this->add($userId, $gameId);
        return 'added';
    }

    /**
     * Hitung jumlah game di wishlist user (dipakai untuk badge counter).
     */
    public function countByUser(int $userId): int {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM wishlist WHERE user_id = :user_id
        ");
        $stmt->execute([':user_id' => $userId]);
        return (int) $stmt->fetchColumn();
    }
}
