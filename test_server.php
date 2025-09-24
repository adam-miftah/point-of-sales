<?php
// Wajib ada untuk menampilkan error fatal
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Memulai tes pemanggilan file...<br><br>";

// Tes 1: Memuat Autoloader Composer (Ini biasanya sudah benar)
require_once __DIR__ . '/vendor/autoload.php';
echo "<strong>[OK]</strong> Autoloader Composer berhasil dimuat.<br>";

// Tes 2: Memuat Model Sales (TAMBAHKAN 'app' DI SINI)
require_once __DIR__ . '/app/models/SalesModel.php'; 
echo "<strong>[OK]</strong> SalesModel.php berhasil dimuat.<br>";

// Tes 3: Memuat Controller Laporan (TAMBAHKAN 'app' DI SINI)
require_once __DIR__ . '/app/controllers/ReportController.php'; 
echo "<strong>[OK]</strong> ReportController.php berhasil dimuat.<br>";

echo "<br><strong>SELAMAT!</strong> Jika Anda melihat pesan ini, semua file di atas berhasil dimuat tanpa error fatal.";
?>