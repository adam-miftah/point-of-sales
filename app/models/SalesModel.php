<?php
require_once __DIR__ . '/../config/Database.php';

class SalesModel {
  public static function all() {
        $db = Database::getInstance();
        $query = "SELECT s.*, c.nama_customer, u.nama_user 
                  FROM sales s
                  JOIN customers c ON s.id_customer = c.id_customer
                  JOIN users u ON s.id_user = u.id_user
                  ORDER BY s.tgl_sales DESC";
        return $db->query($query)->fetchAll();
    }
    public static function create($data) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO sales (id_customer, id_user, tgl_sales, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data['id_customer'],
            $data['id_user'],
            $data['tgl_sales'],
            $data['status']
        ]);
        // Mengembalikan ID dari sales yang baru dibuat
        return $db->lastInsertId();
    }
    public static function countToday() {
    $db = Database::getInstance();
    // CURDATE() adalah fungsi SQL untuk mendapatkan tanggal hari ini
    return $db->query("SELECT COUNT(*) FROM sales WHERE DATE(tgl_sales) = CURDATE()")->fetchColumn();
}

public static function getRecent($limit = 5) {
    $db = Database::getInstance();
    $query = "SELECT sales.*, customers.nama_customer 
              FROM sales 
              JOIN customers ON sales.id_customer = customers.id_customer 
              ORDER BY sales.tgl_sales DESC
              LIMIT :limit";
    $stmt = $db->prepare($query);
    // Bind parameter limit untuk keamanan
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}
public static function findWithDetails($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT s.*, c.nama_customer, u.nama_user 
            FROM sales s
            JOIN customers c ON s.id_customer = c.id_customer
            JOIN users u ON s.id_user = u.id_user
            WHERE s.id_sales = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public static function findByDateRange($startDate, $endDate) {
        $db = Database::getInstance();
        $query = "
            SELECT 
                s.id_sales, 
                s.tgl_sales, 
                c.nama_customer, 
                u.nama_user,
                SUM(t.amount) as total_penjualan
            FROM sales s
            JOIN customers c ON s.id_customer = c.id_customer
            JOIN users u ON s.id_user = u.id_user
            JOIN transactions t ON s.id_sales = t.id_sales
            WHERE DATE(s.tgl_sales) BETWEEN ? AND ?
            GROUP BY s.id_sales, s.tgl_sales, c.nama_customer, u.nama_user
            ORDER BY s.tgl_sales DESC
        ";
        $stmt = $db->prepare($query);
        $stmt->execute([$startDate, $endDate]);
        return $stmt->fetchAll();
    }
}