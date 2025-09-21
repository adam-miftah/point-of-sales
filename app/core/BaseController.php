<?php
// app/core/BaseController.php
class BaseController {
    protected $db;
    public function __construct($db) {
        $this->db = $db;
    }
    protected function view($path, $data = []) {
        extract($data);
        require __DIR__ . "/../views/layout/header.php";
        require __DIR__ . "/../views/{$path}.php";
        require __DIR__ . "/../views/layout/footer.php";
    }
    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }
}
