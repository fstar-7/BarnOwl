<?php

class Order extends Model {

    public function getAll(): array {
        $stmt = $this->db->query("
            SELECT o.*, u.username
            FROM `order` o
            INNER JOIN `user` u ON o.user_id = u.id
            ORDER BY o.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false {
        $stmt = $this->db->prepare("
            SELECT o.*, u.username, u.email
            FROM `order` o
            INNER JOIN `user` u ON o.user_id = u.id
            WHERE o.id = :id
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getItems(int $orderId): array {
        $stmt = $this->db->prepare("
            SELECT oi.*, g.name, g.thumbnail
            FROM order_item oi
            INNER JOIN game g ON oi.game_id = g.id
            WHERE oi.order_id = :order_id
        ");
        $stmt->execute([':order_id' => $orderId]);
        return $stmt->fetchAll();
    }

    public function approve(int $orderId): bool {
        // Ambil items order
        $items = $this->getItems($orderId);
        $order = $this->findById($orderId);
        if (!$order || $order['status'] !== 'pending') return false;

        // Update status order
        $stmt = $this->db->prepare("
            UPDATE `order` SET status = 'paid' WHERE id = :id
        ");
        $stmt->execute([':id' => $orderId]);

        // Masukkan ke library
        $stmtLib = $this->db->prepare("
            INSERT IGNORE INTO library (user_id, game_id, order_id)
            VALUES (:user_id, :game_id, :order_id)
        ");
        foreach ($items as $item) {
            $stmtLib->execute([
                ':user_id'  => $order['user_id'],
                ':game_id'  => $item['game_id'],
                ':order_id' => $orderId,
            ]);
        }
        return true;
    }

    public function getTotalRevenue(): int {
        $stmt = $this->db->query("
            SELECT COALESCE(SUM(total), 0) FROM `order` WHERE status = 'paid'
        ");
        return (int) $stmt->fetchColumn();
    }

    public function exportCsv(): array {
        $stmt = $this->db->query("
            SELECT o.id, u.username, u.email,
                   o.total, o.status, o.created_at
            FROM `order` o
            INNER JOIN `user` u ON o.user_id = u.id
            ORDER BY o.created_at DESC
        ");
        return $stmt->fetchAll();
    }
}
