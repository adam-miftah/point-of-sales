<?php
require_once __DIR__ . '/../config/Database.php';

class UserModel {

    /**
     * ==========================================================
     * TAMBAHKAN METHOD INI
     * Mengambil semua data user, digabung dengan data level.
     * ==========================================================
     * @return array
     */
    public static function all() {
        $db = Database::getInstance();
        $query = "SELECT users.*, levels.level 
                  FROM users 
                  JOIN levels ON users.id_level = levels.id_level 
                  ORDER BY users.nama_user ASC";
        return $db->query($query)->fetchAll();
    }

    /**
     * Mencari satu user berdasarkan ID.
     * @param int $id
     * @return array|false
     */
    public static function find($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE id_user = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Mencari satu user berdasarkan username.
     * @param string $username
     * @return array|false
     */
    public static function findByUsername($username) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    /**
     * Membuat user baru.
     * @param array $data
     * @return bool
     */
    public static function create($data) {
        $db = Database::getInstance();
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt = $db->prepare("INSERT INTO users (nama_user, username, password, id_level) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['nama_user'],
            $data['username'],
            $hashedPassword,
            $data['id_level']
        ]);
    }

    /**
     * Mengupdate data pengguna.
     * @param int $id
     * @param array $data
     * @return bool
     */
    public static function update($id, $data) {
        $db = Database::getInstance();
        
        $queryFields = "nama_user = ?, username = ?, id_level = ?";
        $params = [$data['nama_user'], $data['username'], $data['id_level']];
        
        if (!empty($data['password'])) {
            $queryFields .= ", password = ?";
            $params[] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        
        $params[] = $id;
        
        $stmt = $db->prepare("UPDATE users SET {$queryFields} WHERE id_user = ?");
        return $stmt->execute($params);
    }

    /**
     * Menghapus user berdasarkan ID.
     * @param int $id
     * @return bool
     */
    public static function delete($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM users WHERE id_user = ?");
        return $stmt->execute([$id]);
    }
}