<?php
// app/core/BaseModel.php
class BaseModel {
    protected $db;
    public function __construct($pdo) {
        $this->db = $pdo;
    }
}
