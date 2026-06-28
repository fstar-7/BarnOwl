<?php

class Game extends Model {

    public function getAll(): array {
        $stmt = $this->db->query("
            SELECT g.*, GROUP_CONCAT(gn.name SEPARATOR ', ') AS genres
            FROM game g
            LEFT JOIN game_genre gg ON g.id = gg.game_id
            LEFT JOIN genre gn      ON gg.genre_id = gn.id
            GROUP BY g.id
            ORDER BY g.id DESC
        ");
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false {
        $stmt = $this->db->prepare("
            SELECT g.*, GROUP_CONCAT(gn.name SEPARATOR ', ') AS genres
            FROM game g
            LEFT JOIN game_genre gg ON g.id = gg.game_id
            LEFT JOIN genre gn      ON gg.genre_id = gn.id
            WHERE g.id = :id
            GROUP BY g.id
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

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

    public function getFiltered(array $filters): array {
        $where    = ['1=1'];
        $bindings = [];

        if (!empty($filters['genre_ids'])) {
            $placeholders = implode(',', array_fill(0, count($filters['genre_ids']), '?'));
            $where[]      = "g.id IN (SELECT game_id FROM game_genre WHERE genre_id IN ($placeholders))";
            foreach ($filters['genre_ids'] as $id) $bindings[] = (int) $id;
        }

        if (!empty($filters['platform_ids'])) {
            $placeholders = implode(',', array_fill(0, count($filters['platform_ids']), '?'));
            $where[]      = "g.id IN (SELECT game_id FROM game_platform WHERE platform_id IN ($placeholders))";
            foreach ($filters['platform_ids'] as $id) $bindings[] = (int) $id;
        }

        if (!empty($filters['promo']))     $where[] = 'g.discount > 0';
        if (!empty($filters['top_rated'])) $where[] = 'g.rating >= 4.7';
        if (isset($filters['max_price']))  { $where[] = 'g.price <= ?'; $bindings[] = (int) $filters['max_price']; }

        $whereClause = implode(' AND ', $where);
        $orderBy = match ($filters['sort'] ?? 'popular') {
            'latest'       => 'g.id DESC',
            'lowest_price' => '(g.price - (g.price * (IFNULL(g.discount, 0) / 100))) ASC',
            default        => 'g.views DESC',
        };

        $limit  = (int) ($filters['per_page'] ?? 8);
        $offset = (int) ($filters['offset']   ?? 0);

        $countStmt = $this->db->prepare("SELECT COUNT(*) FROM game g WHERE $whereClause");
        $countStmt->execute($bindings);
        $total = (int) $countStmt->fetchColumn();

        $stmt = $this->db->prepare("SELECT g.* FROM game g WHERE $whereClause ORDER BY $orderBy LIMIT $limit OFFSET $offset");
        $stmt->execute($bindings);

        return ['items' => $stmt->fetchAll(), 'total' => $total];
    }

    public function getTopSelling(int $limit = 5): array {
        $stmt = $this->db->prepare("SELECT * FROM game ORDER BY views DESC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getMaxPrice(): int {
        return (int) ($this->db->query("SELECT MAX(price) FROM game")->fetchColumn() ?: 1000000);
    }

    public function exists(int $id): bool {
        $stmt = $this->db->prepare("SELECT id FROM game WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() !== false;
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare("
            INSERT INTO game (name, description, thumbnail, banner, price, discount, rating, views, status)
            VALUES (:name, :description, :thumbnail, :banner, :price, :discount, :rating, :views, :status)
        ");
        $stmt->execute([
            ':name'        => $data['name'],
            ':description' => $data['description'] ?? '',
            ':thumbnail'   => $data['thumbnail'],
            ':banner'      => $data['banner'] ?? null,
            ':price'       => $data['price'],
            ':discount'    => $data['discount'] ?? 0,
            ':rating'      => $data['rating'] ?? 0.0,
            ':views'       => $data['views'] ?? 0,
            ':status'      => $data['status'] ?? 'regular',
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare("
            UPDATE game SET
                name = :name, description = :description,
                thumbnail = :thumbnail, banner = :banner,
                price = :price, discount = :discount,
                rating = :rating, status = :status
            WHERE id = :id
        ");
        return $stmt->execute([
            ':name'        => $data['name'],
            ':description' => $data['description'] ?? '',
            ':thumbnail'   => $data['thumbnail'],
            ':banner'      => $data['banner'] ?? null,
            ':price'       => $data['price'],
            ':discount'    => $data['discount'] ?? 0,
            ':rating'      => $data['rating'] ?? 0.0,
            ':status'      => $data['status'] ?? 'regular',
            ':id'          => $id,
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM game WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function syncGenres(int $gameId, array $genreIds): void {
        $this->db->prepare("DELETE FROM game_genre WHERE game_id = :id")->execute([':id' => $gameId]);
        $stmt = $this->db->prepare("INSERT IGNORE INTO game_genre (game_id, genre_id) VALUES (:game_id, :genre_id)");
        foreach ($genreIds as $gid) {
            $stmt->execute([':game_id' => $gameId, ':genre_id' => (int) $gid]);
        }
    }

    public function syncPlatforms(int $gameId, array $platformIds): void {
        $this->db->prepare("DELETE FROM game_platform WHERE game_id = :id")->execute([':id' => $gameId]);
        $stmt = $this->db->prepare("INSERT IGNORE INTO game_platform (game_id, platform_id) VALUES (:game_id, :platform_id)");
        foreach ($platformIds as $pid) {
            $stmt->execute([':game_id' => $gameId, ':platform_id' => (int) $pid]);
        }
    }

    public function getGenreIds(int $gameId): array {
        $stmt = $this->db->prepare("SELECT genre_id FROM game_genre WHERE game_id = :id");
        $stmt->execute([':id' => $gameId]);
        return array_column($stmt->fetchAll(), 'genre_id');
    }

    public function getPlatformIds(int $gameId): array {
        $stmt = $this->db->prepare("SELECT platform_id FROM game_platform WHERE game_id = :id");
        $stmt->execute([':id' => $gameId]);
        return array_column($stmt->fetchAll(), 'platform_id');
    }

    public function getTotalCount(): int {
        return (int) $this->db->query("SELECT COUNT(*) FROM game")->fetchColumn();
    }

    /**
     * Ambil daftar platform (id + name) untuk satu game.
     * Dipakai di halaman detail game.
     */
    public function getPlatformsByGame(int $gameId): array {
        $stmt = $this->db->prepare("
            SELECT p.id, p.name
            FROM platform p
            INNER JOIN game_platform gp ON p.id = gp.platform_id
            WHERE gp.game_id = :id
            ORDER BY p.name ASC
        ");
        $stmt->execute([':id' => $gameId]);
        return $stmt->fetchAll();
    }

    /**
     * Ambil game lain yang berbagi genre dengan game ini (untuk
     * section "You May Also Like" di halaman detail).
     */
    public function getRelated(int $gameId, int $limit = 4): array {
        $limit = max(1, $limit);
        $stmt  = $this->db->prepare("
            SELECT DISTINCT g.*
            FROM game g
            INNER JOIN game_genre gg ON g.id = gg.game_id
            WHERE gg.genre_id IN (SELECT genre_id FROM game_genre WHERE game_id = ?)
              AND g.id != ?
            ORDER BY g.views DESC
            LIMIT $limit
        ");
        $stmt->execute([$gameId, $gameId]);
        $related = $stmt->fetchAll();

        // Fallback: kalau game ini tidak punya genre / tidak ada game serupa,
        // tampilkan saja game populer lain biar section tidak kosong.
        if (empty($related)) {
            $stmt = $this->db->prepare("
                SELECT * FROM game WHERE id != ? ORDER BY views DESC LIMIT $limit
            ");
            $stmt->execute([$gameId]);
            $related = $stmt->fetchAll();
        }

        return $related;
    }

    /**
     * Tambah 1 view setiap kali halaman detail game dibuka.
     * Dipakai juga untuk badge HOT & sorting "Most Popular".
     */
    public function incrementViews(int $gameId): void {
        $stmt = $this->db->prepare("UPDATE game SET views = views + 1 WHERE id = :id");
        $stmt->execute([':id' => $gameId]);
    }

    public static function calcFinalPrice(int $price, int $discount): int {
        if ($discount <= 0 || $discount > 100) return $price;
        return (int) ($price - ($price * ($discount / 100)));
    }
}
