<?php

class Game extends Model {

    /**
     * Ambil game dengan status 'featured' beserta genre-nya.
     */
    public function getFeatured(int $limit = 4): array {
        $stmt = $this->db->prepare("
            SELECT g.*, GROUP_CONCAT(gn.name SEPARATOR ', ') AS genres
            FROM game g
            LEFT JOIN game_genre gg ON g.id = gg.game_id
            LEFT JOIN genre gn      ON gg.genre_id = gn.id
            WHERE g.status = 'featured'
            GROUP BY g.id
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Ambil game dengan status 'new_release' beserta genre-nya.
     */
    public function getNewRelease(int $limit = 3): array {
        $stmt = $this->db->prepare("
            SELECT g.*, GROUP_CONCAT(gn.name SEPARATOR ' • ') AS genres
            FROM game g
            LEFT JOIN game_genre gg ON g.id = gg.game_id
            LEFT JOIN genre gn      ON gg.genre_id = gn.id
            WHERE g.status = 'new_release'
            GROUP BY g.id
            ORDER BY g.id DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Hitung harga final setelah diskon.
     * Logika bisnis di Model, bukan di View.
     */
    public static function calcFinalPrice(int $price, int $discount): int {
        if ($discount <= 0 || $discount > 100) return $price;
        return (int) ($price - ($price * ($discount / 100)));
    }
}
