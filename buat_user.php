<?php
/**
 * =================================================================
 * SCRIPT UNTUK MEMBUAT PENGGUNA BARU SECARA PROGRAMATIS
 * =================================================================
 */

// 1. Panggil file Model yang dibutuhkan
// Pastikan path ini benar sesuai struktur folder Anda
require_once __DIR__ . '/app/config/Database.php';
require_once __DIR__ . '/app/models/UserModel.php';

echo "<h1>Membuat Pengguna Baru...</h1>";

// 2. Tentukan data pengguna baru yang ingin Anda tambahkan
$dataUserBaru = [
    'nama_user'  => 'Adam',
    'username'   => 'adam',
    'password'   => 'password123', // Ketik password asli di sini
    'id_level'   => 1              // Ganti ID level (1=Admin, 2=Petugas, etc.)
];

// 3. Panggil method create() dari UserModel
// Method ini akan otomatis mengenkripsi password dengan aman (hashing)
if (UserModel::create($dataUserBaru)) {
    echo "<p style='color:green;'><b>SUKSES!</b> Pengguna '" . htmlspecialchars($dataUserBaru['username']) . "' berhasil ditambahkan ke database.</p>";
    echo "<p>Anda sekarang bisa login menggunakan username dan password di atas.</p>";
} else {
    echo "<p style='color:red;'><b>GAGAL!</b> Tidak dapat menambahkan pengguna ke database.</p>";
}

echo "<hr><p><b>PENTING:</b> Hapus file <b>buat_user.php</b> ini setelah selesai digunakan untuk alasan keamanan.</p>";

?>