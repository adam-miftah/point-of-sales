<?php
require_once __DIR__ . '/../config/Database.php';

class TransactionModel {
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
    public static function findAllBySalesId($salesId) {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT t.*, i.nama_item 
            FROM transactions t 
            JOIN items i ON t.id_item = i.id_item 
            WHERE t.id_sales = ?
        ");
        $stmt->execute([$salesId]);
        return $stmt->fetchAll();
    }
}