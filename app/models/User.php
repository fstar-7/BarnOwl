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

    /** Cek username dipakai user LAIN (bukan dirinya sendiri) — buat validasi form edit profil. */
    public function usernameTakenByOther(string $username, int $exceptId): bool {
        $stmt = $this->db->prepare("SELECT id FROM `user` WHERE username = :username AND id != :id LIMIT 1");
        $stmt->execute([':username' => $username, ':id' => $exceptId]);
        return (bool) $stmt->fetch();
    }

    /** Cek email dipakai user LAIN (bukan dirinya sendiri) — buat validasi form edit profil. */
    public function emailTakenByOther(string $email, int $exceptId): bool {
        $stmt = $this->db->prepare("SELECT id FROM `user` WHERE email = :email AND id != :id LIMIT 1");
        $stmt->execute([':email' => $email, ':id' => $exceptId]);
        return (bool) $stmt->fetch();
    }

    public function updateProfile(int $id, string $username, string $email): bool {
        $stmt = $this->db->prepare("
            UPDATE `user` SET username = :username, email = :email, updated_at = NOW()
            WHERE id = :id
        ");
        return $stmt->execute([':username' => $username, ':email' => $email, ':id' => $id]);
    }

    public function updateAvatar(int $id, ?string $avatarFile): bool {
        $stmt = $this->db->prepare("UPDATE `user` SET avatar = :avatar, updated_at = NOW() WHERE id = :id");
        return $stmt->execute([':avatar' => $avatarFile, ':id' => $id]);
    }

    public function updatePassword(int $id, string $newPassword): bool {
        $stmt = $this->db->prepare("UPDATE `user` SET password = :password, updated_at = NOW() WHERE id = :id");
        return $stmt->execute([
            ':password' => password_hash($newPassword, PASSWORD_DEFAULT),
            ':id'       => $id,
        ]);
    }

    public function exportCsv(): array {
        $stmt = $this->db->query("SELECT id, username, email, role, created_at FROM `user` ORDER BY id ASC");
        return $stmt->fetchAll();
    }
}
