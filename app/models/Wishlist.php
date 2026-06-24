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
}
