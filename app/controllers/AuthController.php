<?php
require_once __DIR__ . '../../models/UserModel.php';
class AuthController {
    public function showLoginForm() {
        require __DIR__ . '/../views/auth/login.php';
    }

    /**
     * Memproses data yang dikirim dari form login.
     * Dipanggil oleh router saat request POST.
     */
    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Cari user berdasarkan username menggunakan UserModel
            $user = UserModel::findByUsername($username); 

            // Verifikasi user dan password
            if ($user && password_verify($password, $user['password'])) {
                // Jika berhasil, mulai session
                session_start();
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['level'] = $user['id_level']; // Simpan juga level user

                // Redirect ke halaman dashboard atau halaman utama
                // Pastikan Anda memiliki routing untuk controller=dashboard
                header("Location: index.php?controller=dashboard"); 
                exit;
            } else {
                // Jika gagal, kembali ke form login dengan pesan error
                $error = "Username atau password salah!";
                require __DIR__ . '/../views/auth/login.php';
            }
        }
    }

    /**
     * Menghapus session dan mengeluarkan user.
     */
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: index.php?controller=auth&action=login");
        exit;
    }
}