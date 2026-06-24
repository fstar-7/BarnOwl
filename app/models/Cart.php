<?php

// Tambahkan "extends Model"
class Cart extends Model {
    
    // Sama, hapus __construct() beserta isinya!
    
    public function getCartSummary($userId) {
        $query = "SELECT carts.id AS cart_id, games.id AS game_id, games.name, games.price, games.image 
                  FROM carts 
                  INNER JOIN games ON carts.game_id = games.id 
                  WHERE carts.user_id = :user_id";
                  
        // Variabel $this->db bisa langsung dipakai!
        $stmt = $this->db->prepare($query);
        $stmt->execute(['user_id' => $userId]);
        
        $items = $stmt->fetchAll();
        
        $totalItems = count($items);
        $subtotal = 0;
        
        foreach ($items as &$item) {
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