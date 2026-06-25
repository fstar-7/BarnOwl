<?php

class Genre extends Model {

    /**
     * Ambil semua genre (untuk sidebar filter di store).
     */
    public function getAll(): array {
        return $this->db->query("SELECT * FROM genre ORDER BY name ASC")->fetchAll();
    }

    /**
     * Ambil genre beserta jumlah game-nya (untuk section kategori di home).
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
