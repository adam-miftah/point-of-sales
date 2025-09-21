<?php
require_once __DIR__ . '/../config/Database.php';

class CustomerModel {
    public static function all() {
        $db = Database::getInstance();
        return $db->query("SELECT * FROM customers ORDER BY nama_customer ASC")->fetchAll();
    }

    public static function find($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM customers WHERE id_customer = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($data) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO customers (nama_customer, alamat, telp, email) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['nama_customer'],
            $data['alamat'],
            $data['telp'],
            $data['email']
        ]);
    }

    public static function update($id, $data) {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE customers SET nama_customer=?, alamat=?, telp=?, email=? WHERE id_customer=?");
        return $stmt->execute([
            $data['nama_customer'],
            $data['alamat'],
            $data['telp'],
            $data['email'],
            $id
        ]);
    }

    public static function delete($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM customers WHERE id_customer = ?");
        return $stmt->execute([$id]);
    }
    public static function count() {
    $db = Database::getInstance();
    // Mengambil nilai tunggal (jumlah baris)
    return $db->query("SELECT COUNT(*) FROM customers")->fetchColumn();
}
public static function allWithTransactionSummary() {
        $db = Database::getInstance();
        $query = "
            SELECT 
                c.id_customer,
                c.nama_customer,
                c.alamat,
                c.telp,
                COUNT(s.id_sales) as jumlah_transaksi,
                SUM(t.amount) as total_belanja
            FROM customers c
            LEFT JOIN sales s ON c.id_customer = s.id_customer
            LEFT JOIN transactions t ON s.id_sales = t.id_sales
            GROUP BY c.id_customer, c.nama_customer, c.alamat, c.telp
            ORDER BY total_belanja DESC
        ";
        return $db->query($query)->fetchAll();
    }
}