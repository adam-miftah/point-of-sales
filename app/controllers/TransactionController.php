<?php
require_once __DIR__ . '/../config/Database.php';

class TransactionController {
    public static function all() {
        $db = Database::getInstance();
        // Query ini bisa lebih kompleks, menggabungkan dengan item, sales, dll.
        return $db->query("SELECT * FROM transactions")->fetchAll();
    }

    public static function find($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM transactions WHERE id_transaction = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public static function create($data) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO transactions (id_sales, id_item, quantity, price, amount) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['id_sales'],
            $data['id_item'],
            $data['quantity'],
            $data['price'],
            $data['amount']
        ]);
    }
}