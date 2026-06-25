<?php

class StoreHero extends Model {

    /**
     * Ambil store hero yang aktif.
     */
    public function getActive(): ?array {
        $stmt = $this->db->query("
            SELECT * FROM store_hero
            WHERE is_active = 1
            LIMIT 1
        ");
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
