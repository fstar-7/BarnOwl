<?php

class Genre extends Model {

    /**
     * Ambil genre beserta jumlah game-nya, urut dari terbanyak.
     */
    public function getWithGameCount(int $limit = 6): array {
        $stmt = $this->db->prepare("
            SELECT g.id, g.name, COUNT(gg.game_id) AS total_games
            FROM genre g
            LEFT JOIN game_genre gg ON g.id = gg.genre_id
            GROUP BY g.id
            ORDER BY total_games DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
