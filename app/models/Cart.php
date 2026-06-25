<?php

class Cart extends Model {

    public function getCartSummary(int $userId): array {
        $stmt = $this->db->prepare("
            SELECT
                c.id       AS cart_id,
                g.id       AS game_id,
                g.name,
                g.price,
                g.discount,
                g.thumbnail AS image
            FROM cart c
            INNER JOIN game g ON c.game_id = g.id
            WHERE c.user_id = :user_id
        ");
        $stmt->execute([':user_id' => $userId]);
        $items = $stmt->fetchAll();

        $subtotal = 0;
        foreach ($items as &$item) {
            $item['finalPrice'] = Game::calcFinalPrice(
                (int) $item['price'],
                (int) ($item['discount'] ?? 0)
            );
            $subtotal += $item['finalPrice'];
        }
        unset($item);

        return [
            'items'      => $items,
            'totalItems' => count($items),
            'subtotal'   => $subtotal,
        ];
    }

    public function add(int $userId, int $gameId): bool {
        $stmt = $this->db->prepare("
            INSERT IGNORE INTO cart (user_id, game_id)
            VALUES (:user_id, :game_id)
        ");
        return $stmt->execute([':user_id' => $userId, ':game_id' => $gameId]);
    }

    public function remove(int $cartId, int $userId): bool {
        $stmt = $this->db->prepare("
            DELETE FROM cart
            WHERE id = :id AND user_id = :user_id
        ");
        return $stmt->execute([':id' => $cartId, ':user_id' => $userId]);
    }
}
