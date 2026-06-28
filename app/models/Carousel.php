<?php

class Carousel extends Model {

    public function getActive(): array {
        $stmt = $this->db->query("
            SELECT * FROM carousel WHERE is_active = 1 ORDER BY `order` ASC
        ");
        return $stmt->fetchAll();
    }

    public function getAll(): array {
        $stmt = $this->db->query("
            SELECT c.*, g.name AS game_name
            FROM carousel c
            LEFT JOIN game g ON c.game_id = g.id
            ORDER BY c.order ASC
        ");
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM carousel WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare("
            INSERT INTO carousel (title, subtitle, description, image, `order`, is_active, game_id)
            VALUES (:title, :subtitle, :description, :image, :order, :is_active, :game_id)
        ");
        return $stmt->execute([
            ':title'       => $data['title'],
            ':subtitle'    => $data['subtitle'] ?? null,
            ':description' => $data['description'] ?? null,
            ':image'       => $data['image'],
            ':order'       => $data['order'] ?? 1,
            ':is_active'   => $data['is_active'] ?? 1,
            ':game_id'     => $data['game_id'] ?: null,
        ]);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare("
            UPDATE carousel SET
                title = :title, subtitle = :subtitle,
                description = :description, image = :image,
                `order` = :order, is_active = :is_active, game_id = :game_id
            WHERE id = :id
        ");
        return $stmt->execute([
            ':title'       => $data['title'],
            ':subtitle'    => $data['subtitle'] ?? null,
            ':description' => $data['description'] ?? null,
            ':image'       => $data['image'],
            ':order'       => $data['order'] ?? 1,
            ':is_active'   => $data['is_active'] ?? 1,
            ':game_id'     => $data['game_id'] ?: null,
            ':id'          => $id,
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM carousel WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function toggleActive(int $id): bool {
        $stmt = $this->db->prepare("UPDATE carousel SET is_active = NOT is_active WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function moveOrder(int $id, string $direction): void {
        $slide = $this->findById($id);
        if (!$slide) return;

        $currentOrder = (int) $slide['order'];
        $newOrder     = $direction === 'up' ? $currentOrder - 1 : $currentOrder + 1;

        // Jangan geser kalau sudah di posisi paling atas/bawah —
        // mencegah slide diberi nilai `order` yang tidak dimiliki slide lain.
        if ($newOrder < 1) return;

        // Tukar urutan dengan slide di posisi target
        $stmt = $this->db->prepare("UPDATE carousel SET `order` = :old WHERE `order` = :new");
        $stmt->execute([':old' => $currentOrder, ':new' => $newOrder]);

        if ($stmt->rowCount() === 0) return; // tidak ada slide di posisi target, batalkan

        $stmt = $this->db->prepare("UPDATE carousel SET `order` = :new WHERE id = :id");
        $stmt->execute([':new' => $newOrder, ':id' => $id]);
    }
}
