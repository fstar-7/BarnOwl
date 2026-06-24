<?php

class Cart extends Model {
    
    public function getCartSummary($userId) {
        // PERBAIKAN: Menggunakan tabel 'cart' dan 'game', serta kolom 'thumbnail'
        $query = "SELECT cart.id AS cart_id, game.id AS game_id, game.name, game.price, game.thumbnail AS image 
                  FROM cart 
                  INNER JOIN game ON cart.game_id = game.id 
                  WHERE cart.user_id = :user_id";
                  
        $stmt = $this->db->prepare($query);
        $stmt->execute(['user_id' => $userId]);
        
        $items = $stmt->fetchAll();
        
        $totalItems = count($items);
        $subtotal = 0;
        
        foreach ($items as &$item) {
            // Nanti kamu bisa tambahkan logika diskon di sini jika diperlukan
            $item['finalPrice'] = $item['price'];
            $subtotal += $item['finalPrice'];
        }

        return [
            'items' => $items,
            'totalItems' => $totalItems,
            'subtotal' => $subtotal
        ];
    }
}