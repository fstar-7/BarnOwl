<?php

class User extends Model {

    public function findByUsername(string $username): array|false {
        $stmt = $this->db->prepare("SELECT * FROM `user` WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch();
    }

    public function findByEmail(string $email): array|false {
        $stmt = $this->db->prepare("SELECT * FROM `user` WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function findById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM `user` WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getAll(): array {
        $stmt = $this->db->query("SELECT id, username, email, role, avatar, created_at FROM `user` ORDER BY id ASC");
        return $stmt->fetchAll();
    }

    public function getTotalCount(): int {
        return (int) $this->db->query("SELECT COUNT(*) FROM `user`")->fetchColumn();
    }

    public function register(string $username, string $email, string $password): bool {
        $stmt = $this->db->prepare("
            INSERT INTO `user` (username, email, password, role)
            VALUES (:username, :email, :password, 'user')
        ");
        return $stmt->execute([
            ':username' => $username,
            ':email'    => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM `user` WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function exportCsv(): array {
        $stmt = $this->db->query("SELECT id, username, email, role, created_at FROM `user` ORDER BY id ASC");
        return $stmt->fetchAll();
    }
}
