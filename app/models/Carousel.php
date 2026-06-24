<?php

class Carousel extends Model {

    /**
     * Ambil semua carousel yang aktif, urut berdasarkan kolom order.
     */
    public function getActive(): array {
        $stmt = $this->db->query("
            SELECT * FROM carousel
            WHERE is_active = 1
            ORDER BY `order` ASC
        ");
        return $stmt->fetchAll();
    }
}
