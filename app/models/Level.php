<?php
require_once __DIR__ . '/../config/Database.php';

class Level {
    public static function all() {
        $db = Database::getInstance();
        return $db->query("SELECT * FROM levels ORDER BY level ASC")->fetchAll();
    }
}