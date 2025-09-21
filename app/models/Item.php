<?php
require_once __DIR__ . '/../config/Database.php';

class Item {
    public static function all() {
        $db = Database::getInstance();
        return $db->query("SELECT * FROM items ORDER BY nama_item ASC")->fetchAll();
    }

    public static function find($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM items WHERE id_item = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($data) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO items (nama_item, uom, harga_beli, harga_jual, stok) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['nama_item'],
            $data['uom'],
            $data['harga_beli'],
            $data['harga_jual'],
            $data['stok']
        ]);
    }

    public static function update($id, $data) {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE items SET nama_item=?, uom=?, harga_beli=?, harga_jual=?, stok=? WHERE id_item=?");
        return $stmt->execute([
            $data['nama_item'],
            $data['uom'],
            $data['harga_beli'],
            $data['harga_jual'],
            $data['stok'],
            $id
        ]);
    }

    public static function delete($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM items WHERE id_item = ?");
        return $stmt->execute([$id]);
    }

    public static function count() {
        $db = Database::getInstance();
        return $db->query("SELECT COUNT(*) FROM items")->fetchColumn();
    }

    public static function allWithStockSummary() {
        $db = Database::getInstance();
        $query = "
            SELECT 
                i.id_item,
                i.nama_item,
                i.uom,
                i.harga_jual,
                i.stok,
                IFNULL(SUM(t.quantity), 0) as total_terjual,
                IFNULL(SUM(t.amount), 0) as total_pendapatan
            FROM items i
            LEFT JOIN transactions t ON i.id_item = t.id_item
            GROUP BY i.id_item, i.nama_item, i.uom, i.harga_jual
            ORDER BY total_terjual DESC
        ";
        return $db->query($query)->fetchAll();
    }
    
    // Metode ini diganti namanya agar tidak duplikat dengan yang di bawah
    public static function searchWithSummaryAndStock($keyword) {
        $db = Database::getInstance();
        $sqlKeyword = '%' . $keyword . '%';
        
        $query = "
            SELECT 
                i.id_item, i.nama_item, i.uom, i.harga_jual, i.stok,
                IFNULL(SUM(t.quantity), 0) as total_terjual,
                IFNULL(SUM(t.amount), 0) as total_pendapatan
            FROM items i
            LEFT JOIN transactions t ON i.id_item = t.id_item
            WHERE i.nama_item LIKE ?
            GROUP BY i.id_item, i.nama_item, i.uom, i.harga_jual
            ORDER BY total_terjual DESC
        ";
        
        $stmt = $db->prepare($query);
        $stmt->execute([$sqlKeyword]);
        return $stmt->fetchAll();
    }

    // Hanya pertahankan satu metode reduceStock ini
    public static function reduceStock($itemId, $quantity) {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE items SET stok = stok - ? WHERE id_item = ?");
        return $stmt->execute([$quantity, $itemId]);
    }
}