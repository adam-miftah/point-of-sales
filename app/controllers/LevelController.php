<?php
require_once __DIR__ . '/../models/Level.php';

class LevelController {
    public function index() {
        $levels = Level::all();
        require __DIR__ . '/../views/level/index.php';
    }
    // Level biasanya dikelola langsung di database, 
    // jadi create/update dari UI mungkin tidak diperlukan
}