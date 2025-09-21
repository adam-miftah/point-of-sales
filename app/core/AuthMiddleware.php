<?php
// app/core/AuthMiddleware.php
class AuthMiddleware {
    public static function check() {
        session_start();
        if(!isset($_SESSION['user'])) {
            header("Location: /"); // menuju login (public/index.php)
            exit;
        }
    }
    public static function checkRole($roles = []) {
        self::check();
        if(!in_array($_SESSION['user']['level_name'], $roles)) {
            die("Akses ditolak. Anda tidak memiliki hak untuk mengakses halaman ini.");
        }
    }
}
