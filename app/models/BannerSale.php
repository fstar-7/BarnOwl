<?php

class BannerSale extends Model {

    /**
     * Ambil banner sale yang sedang aktif.
     */
    public function getActive(): ?array {
        $stmt = $this->db->query("
            SELECT * FROM banner_sale
            WHERE is_active = 1
            ORDER BY id DESC
            LIMIT 1
        ");
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
