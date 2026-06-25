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
     * Ambil game dengan filter dinamis + pagination.
     * Mengembalikan ['items' => [...], 'total' => int]
     */
    public function getFiltered(array $filters): array {
        $where    = ['1=1'];
        $bindings = [];

        // Filter genre (subquery IN)
        if (!empty($filters['genre_ids'])) {
            $placeholders = implode(',', array_fill(0, count($filters['genre_ids']), '?'));
            $where[]      = "g.id IN (
                SELECT game_id FROM game_genre WHERE genre_id IN ($placeholders)
            )";
            foreach ($filters['genre_ids'] as $id) {
                $bindings[] = (int) $id;
            }
        }

        // Filter platform
        if (!empty($filters['platform_ids'])) {
            $placeholders = implode(',', array_fill(0, count($filters['platform_ids']), '?'));
            $where[]      = "g.id IN (
                SELECT game_id FROM game_platform WHERE platform_id IN ($placeholders)
            )";
            foreach ($filters['platform_ids'] as $id) {
                $bindings[] = (int) $id;
            }
        }

        // Shortcut: promo
        if (!empty($filters['promo'])) {
            $where[] = 'g.discount > 0';
        }

        // Shortcut: top rated
        if (!empty($filters['top_rated'])) {
            $where[] = 'g.rating >= 4.7';
        }

        // Max price
        if (isset($filters['max_price'])) {
            $where[]    = 'g.price <= ?';
            $bindings[] = (int) $filters['max_price'];
        }

        $whereClause = implode(' AND ', $where);

        // Sorting
        $orderBy = match ($filters['sort'] ?? 'popular') {
            'latest'       => 'g.id DESC',
            'lowest_price' => '(g.price - (g.price * (IFNULL(g.discount, 0) / 100))) ASC',
            default        => 'g.views DESC',
        };

        // Hitung total dulu (untuk pagination)
        $countStmt = $this->db->prepare("SELECT COUNT(*) FROM game g WHERE $whereClause");
        $countStmt->execute($bindings);
        $total = (int) $countStmt->fetchColumn();

        // Query utama + pagination
        $limit  = (int) ($filters['per_page'] ?? 8);
        $offset = (int) ($filters['offset']   ?? 0);

        // PDO tidak bisa bind LIMIT/OFFSET via positional pada beberapa driver
        // jadi cast langsung ke int (aman karena sudah divalidasi di controller)
        $stmt = $this->db->prepare("
            SELECT g.*
            FROM game g
            WHERE $whereClause
            ORDER BY $orderBy
            LIMIT $limit OFFSET $offset
        ");
        $stmt->execute($bindings);

        return [
            'items' => $stmt->fetchAll(),
            'total' => $total,
        ];
    }

    /**
     * Ambil game terlaris berdasarkan views.
     */
    public function getTopSelling(int $limit = 5): array {
        $stmt = $this->db->prepare("
            SELECT * FROM game
            ORDER BY views DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Ambil harga tertinggi dari seluruh game (untuk slider max price).
     */
    public function getMaxPrice(): int {
        $stmt = $this->db->query("SELECT MAX(price) FROM game");
        return (int) ($stmt->fetchColumn() ?: 1000000);
    }

    /**
     * Cek apakah game dengan ID tersebut benar-benar ada.
     * Dipakai untuk validasi sebelum INSERT ke tabel lain (wishlist, cart, dll),
     * karena INSERT IGNORE tidak selalu melempar exception saat FK constraint
     * gagal — ia hanya mengubahnya jadi warning, bukan PDOException.
     */
    public function exists(int $id): bool {
        $stmt = $this->db->prepare("SELECT id FROM game WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() !== false;
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
