<?php

class Database {
    private static $host = 'localhost';
    private static $db_name = 'db_pos_koperasi'; 
    private static $username = 'root';
    private static $password = '';
    private static $conn = null;

    /**
     * Mendapatkan koneksi PDO. Dibuat hanya sekali.
     * @return PDO Objek koneksi PDO.
     */
    public static function getInstance() {
        if (self::$conn === null) {
            try {
                $dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$db_name;
                self::$conn = new PDO($dsn, self::$username, self::$password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die('Koneksi Gagal: ' . $e->getMessage());
            }
        }
        return self::$conn;
    }
}