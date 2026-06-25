<?php

class Platform extends Model {

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM platform ORDER BY name ASC");
        return $stmt->fetchAll();
    }
}
