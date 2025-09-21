<?php
// index.php sebagai entry point utama
session_start();

// panggil router
require_once __DIR__ . '/routes.php';
