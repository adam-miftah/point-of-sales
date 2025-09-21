<?php
require_once __DIR__ . '/../config/Database.php';

class Identitas {
    public static function find($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM identitas WHERE id_identitas = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function update($id, $data) {
        $db = Database::getInstance();
        // Sesuaikan nama kolom dengan tabel Anda
        $stmt = $db->prepare("UPDATE identitas SET nama_identitas=?, badan_hukum=?, alamat=?, telp=?, email=? WHERE id_identitas=?");
        return $stmt->execute([
            $data['nama_identitas'],
            $data['badan_hukum'],
            $data['alamat'],
            $data['telp'],
            $data['email'],
            $id
        ]);
    }
}